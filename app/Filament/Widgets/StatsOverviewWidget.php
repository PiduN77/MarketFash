<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getFilters(): ?array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // Generate last 12 months options
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $months[$key] = $date->format('F Y');
        }

        return [
            'periodMonth' => [
                'label' => 'Month Period',
                'type' => 'select',
                'options' => $months,
                'default' => Carbon::now()->format('Y-m'),
            ],
            'businessCustomersOnly' => [
                'label' => 'Business Customers Only',
                'type' => 'boolean',
            ],
        ];
    }

    protected function getStats(): array
    {
        // Get selected period or default to current month
        $selectedPeriod = $this->filters['periodMonth'] ?? Carbon::now()->format('Y-m');
        $periodDate = Carbon::createFromFormat('Y-m', $selectedPeriod);
        
        $startDate = $periodDate->copy()->startOfMonth();
        $endDate = $periodDate->copy()->endOfMonth();

        $isBusinessCustomersOnly = $this->filters['businessCustomersOnly'] ?? null;

        $query = Order::query()
            ->whereBetween('order_date', [$startDate, $endDate]);

        if ($isBusinessCustomersOnly !== null) {
            $query->whereHas('customerAddress.customer', function ($q) use ($isBusinessCustomersOnly) {
                $q->where('is_business', $isBusinessCustomersOnly);
            });
        }

        // Calculate current period stats
        $revenue = $query->sum('total_amount');
        $totalOrders = $query->count();
        $newOrders = $query->where('shipment_status', null)->count();

        // Calculate total customers for the period
        $totalCustomers = User::where('userType', 'C')
            ->whereHas('customers', function($query) use ($startDate, $endDate) {
                $query->whereHas('cusAddress', function($addressQuery) use ($startDate, $endDate) {
                    $addressQuery->whereHas('orders', function($orderQuery) use ($startDate, $endDate) {
                        $orderQuery->whereBetween('order_date', [$startDate, $endDate]);
                    });
                });
            })
            ->count();

        // Calculate previous month stats
        $previousMonthStart = $startDate->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $startDate->copy()->subMonth()->endOfMonth();

        $previousMonthRevenue = Order::whereBetween('order_date', [$previousMonthStart, $previousMonthEnd])
            ->sum('total_amount');
        $previousMonthTotalOrders = Order::whereBetween('order_date', [$previousMonthStart, $previousMonthEnd])
            ->count();
        $previousMonthNewOrders = Order::whereBetween('order_date', [$previousMonthStart, $previousMonthEnd])
            ->where('shipment_status', null)
            ->count();
        $previousMonthCustomers = User::where('userType', 'C')
            ->whereHas('customers', function($query) use ($previousMonthStart, $previousMonthEnd) {
                $query->whereHas('cusAddress', function($addressQuery) use ($previousMonthStart, $previousMonthEnd) {
                    $addressQuery->whereHas('orders', function($orderQuery) use ($previousMonthStart, $previousMonthEnd) {
                        $orderQuery->whereBetween('order_date', [$previousMonthStart, $previousMonthEnd]);
                    });
                });
            })
            ->count();

        // Calculate percentage changes
        $revenueChange = $this->calculatePercentageChange($previousMonthRevenue, $revenue);
        $totalOrdersChange = $this->calculatePercentageChange($previousMonthTotalOrders, $totalOrders);
        $newOrdersChange = $this->calculatePercentageChange($previousMonthNewOrders, $newOrders);
        $customersChange = $this->calculatePercentageChange($previousMonthCustomers, $totalCustomers);

        $formatNumber = function ($number): string {
            return 'Rp ' . number_format($number, 0, ',', '.');
        };

        return [
            Stat::make('Revenue', $formatNumber($revenue))
                ->description($revenueChange['description'])
                ->descriptionIcon($revenueChange['icon'])
                ->chart($this->getChartData('total_amount', 'sum'))
                ->color($revenueChange['color']),
            Stat::make('Total Orders', $totalOrders)
                ->description($totalOrdersChange['description'])
                ->descriptionIcon($totalOrdersChange['icon'])
                ->chart($this->getChartData('order_code', 'count', false))
                ->color($totalOrdersChange['color']),
            Stat::make('New Orders', $newOrders)
                ->description($newOrdersChange['description'])
                ->descriptionIcon($newOrdersChange['icon'])
                ->chart($this->getChartData('order_code', 'count', false, true))
                ->color($newOrdersChange['color']),
            Stat::make('Total Customers', $totalCustomers)
                ->description($customersChange['description'])
                ->descriptionIcon($customersChange['icon'])
                ->chart($this->getCustomerChartData())
                ->color($customersChange['color']),
        ];
    }

    protected function calculatePercentageChange($oldValue, $newValue): array
    {
        if ($oldValue == 0) {
            return [
                'description' => '100% increase',
                'icon' => 'heroicon-m-arrow-trending-up',
                'color' => 'success'
            ];
        }

        $percentageChange = (($newValue - $oldValue) / $oldValue) * 100;

        return [
            'description' => abs(round($percentageChange)) . '% ' . ($percentageChange >= 0 ? 'increase' : 'decrease'),
            'icon' => $percentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down',
            'color' => $percentageChange >= 0 ? 'success' : 'danger'
        ];
    }

    protected function getChartData($column, $aggregate = 'sum', $isDistinct = false, $newOrdersOnly = false): array
    {
        $selectedPeriod = $this->filters['periodMonth'] ?? Carbon::now()->format('Y-m');
        $periodDate = Carbon::createFromFormat('Y-m', $selectedPeriod);
        
        // Get the number of days in the selected month
        $daysInMonth = $periodDate->daysInMonth;
        
        $data = Order::query()
            ->when($newOrdersOnly, fn($query) => $query->whereNull('shipment_status'))
            ->whereBetween('order_date', [
                $periodDate->copy()->startOfMonth(),
                $periodDate->copy()->endOfMonth()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE(order_date) as date'),
                DB::raw(($isDistinct ? "COUNT(DISTINCT $column)" : "$aggregate($column)") . ' as value')
            ])
            ->pluck('value')
            ->toArray();

        return array_pad($data, -$daysInMonth, 0);
    }

    protected function getCustomerChartData(): array
    {
        $selectedPeriod = $this->filters['periodMonth'] ?? Carbon::now()->format('Y-m');
        $periodDate = Carbon::createFromFormat('Y-m', $selectedPeriod);
        $daysInMonth = $periodDate->daysInMonth;

        $data = User::where('userType', 'C')
            ->whereHas('customers', function($query) use ($periodDate) {
                $query->whereHas('cusAddress', function($addressQuery) use ($periodDate) {
                    $addressQuery->whereHas('orders', function($orderQuery) use ($periodDate) {
                        $orderQuery->whereBetween('order_date', [
                            $periodDate->copy()->startOfMonth(),
                            $periodDate->copy()->endOfMonth()
                        ]);
                    });
                });
            })
            ->selectRaw('DATE(created_at) as date, COUNT(*) as value')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('value')
            ->toArray();

        return array_pad($data, -$daysInMonth, 0);
    }
}