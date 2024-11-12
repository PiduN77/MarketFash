<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\OrderItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PopularProductsTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function getTableRecordKey(Model $record): string
    {
        return $record->variation_size_id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderItem::query()
                    ->select([
                        'order_items.variation_size_id',
                        DB::raw('SUM(order_items.qty) as total_ordered'),
                        DB::raw('COUNT(DISTINCT order_items.order_code) as order_count'),
                        DB::raw('MAX(order_items.created_at) as last_ordered')
                    ])
                    ->join('variation_sizes', 'order_items.variation_size_id', '=', 'variation_sizes.variation_size_id')
                    ->join('variation_photos', 'variation_sizes.photo_id', '=', 'variation_photos.photo_id')
                    ->join('product_variations', 'variation_photos.variation_id', '=', 'product_variations.variation_id')
                    ->join('products', 'product_variations.product_id', '=', 'products.product_id')
                    ->where('products.shop_id', function ($query) {
                        $query->select('shops.shop_id')
                            ->from('shops')
                            ->join('sellers', 'shops.seller_ktp_nik', '=', 'sellers.ktp_nik')
                            ->join('customers', 'sellers.customer_id', '=', 'customers.customer_id')
                            ->join('users', 'customers.user_id', '=', 'users.id')
                            ->where('users.id', auth()->id())
                            ->limit(1);
                    })
                    ->with([
                        'variationSize.photo.variation.product',
                        'variationSize.photo.variation',
                    ])
                    ->groupBy([
                        'order_items.variation_size_id',
                        'variation_sizes.variation_size_id',
                        'variation_sizes.photo_id',
                        'variation_photos.photo_id',
                        'variation_photos.variation_id',
                        'product_variations.variation_id',
                        'product_variations.product_id',
                        'products.product_id',
                        'products.name'
                    ])
                    ->orderByDesc('total_ordered')
            )
            ->columns([
                ImageColumn::make('variationSize.photo.directory')
                    ->label('Photo')
                    ->circular(),
                    
                TextColumn::make('variationSize.photo.variation.product.name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('variationSize.photo.variation.color')
                    ->label('Color')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('variationSize.size')
                    ->label('Size')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('total_ordered')
                    ->label('Total Sold')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('order_count')
                    ->label('Order Count')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('last_ordered')
                    ->label('Last Order')
                    ->dateTime()
                    ->sortable(),
                    
                TextColumn::make('variationSize.stock')
                    ->label('Current Stock')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('total_ordered', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->heading('Popular Products');
    }

   
}