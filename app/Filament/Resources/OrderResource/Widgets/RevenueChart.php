<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected int | string | array $columnSpan = 2;
    protected static ?string $heading = 'Revenue per Month';
    protected static ?int $sort = 4;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(order_date) as month'),
            DB::raw('SUM(total_amount) as total_revenue')
        )
        ->whereYear('order_date', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total_revenue', 'month')
        ->toArray();

        $data = array_fill(1, 12, 0); // Initialize all months with zero

        foreach ($monthlyRevenue as $month => $revenue) {
            $data[$month] = $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => array_values($data),
                    'fill' => 'start',
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) {
                            return "Rp " + new Intl.NumberFormat().format(value);
                        }',
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "Revenue: Rp " + new Intl.NumberFormat().format(context.parsed.y);
                        }',
                    ],
                ],
            ],
        ];
    }
}