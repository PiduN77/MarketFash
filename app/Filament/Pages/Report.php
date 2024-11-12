<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class Reports extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static ?string $title = 'Laporan Penjualan';
    protected static ?string $slug = 'laporan-penjualan';
    
    // Set the view property
    protected static string $view = 'filament.pages.sales-report';

    public $startDate;
    public $endDate;
    public $reportType = 'sales1';

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Tanggal Mulai')
                    ->required(),
                DatePicker::make('endDate')
                    ->label('Tanggal Akhir')
                    ->required(),
                Select::make('reportType')
                    ->label('Jenis Laporan')
                    ->options([
                        'sales1' => 'Laporan Penjualan 1',
                        'sales2' => 'Laporan Penjualan 2',
                    ])
                    ->required()
                    ->live(),
            ])
            ->columns(3);
    }

    public function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        if ($this->reportType === 'sales1') {
            return Order::query()
                ->whereBetween('order_date', [$this->startDate, $this->endDate])
                ->orderBy('order_date', 'desc');
        }

        return OrderItem::query()
            ->select([
                'products.name as product_name',
                \DB::raw('SUM(order_items.qty) as total_qty'),
                \DB::raw('SUM(order_items.qty * variation_sizes.price) as total_sales')
            ])
            ->join('orders', 'orders.order_code', '=', 'order_items.order_code')
            ->join('variation_sizes', 'variation_sizes.variation_size_id', '=', 'order_items.variation_size_id')
            ->join('variation_photos', 'variation_photos.photo_id', '=', 'variation_sizes.photo_id')
            ->join('product_variations', 'product_variations.variation_id', '=', 'variation_photos.variation_id')
            ->join('products', 'products.product_id', '=', 'product_variations.product_id')
            ->whereBetween('orders.order_date', [$this->startDate, $this->endDate])
            ->groupBy('products.name');
    }

    public function getTableColumns(): array
    {
        if ($this->reportType === 'sales1') {
            return [
                TextColumn::make('order_date')
                    ->label('Tanggal Order')
                    ->date('d/m/Y'),
                TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->searchable(),
                TextColumn::make('customerAddress.customer.FName')
                    ->label('Nama Pembeli'),
                TextColumn::make('payment_name')
                    ->label('Metode Pembayaran'),
                TextColumn::make('payment_status')
                    ->label('Status Pembayaran'),
            ];
        }

        return [
            TextColumn::make('product_name')
                ->label('Nama Produk')
                ->searchable(),
            TextColumn::make('total_qty')
                ->label('Qty Terjual'),
            TextColumn::make('total_sales')
                ->label('Penjualan (Rp)')
                ->money('IDR'),
        ];
    }

    public function getTableDefaultSortColumn(): ?string
    {
        return $this->reportType === 'sales2' ? 'total_sales' : null;
    }

    public function getTableDefaultSortDirection(): ?string
    {
        return $this->reportType === 'sales2' ? 'desc' : null;
    }

    protected function getData(): array
    {
        $totalSales = 0;
        
        if ($this->reportType === 'sales2') {
            $totalSales = OrderItem::query()
                ->join('orders', 'orders.order_code', '=', 'order_items.order_code')
                ->join('variation_sizes', 'variation_sizes.variation_size_id', '=', 'order_items.variation_size_id')
                ->whereBetween('orders.order_date', [$this->startDate, $this->endDate])
                ->sum(\DB::raw('order_items.qty * variation_sizes.price'));
        }

        return [
            'totalSales' => $totalSales,
            'downloadUrlPdf' => '#',
            'downloadUrlCsv' => '#',
            'downloadUrlXlsx' => '#',
        ];
    }
}