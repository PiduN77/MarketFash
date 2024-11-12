<?php

namespace App\Filament\Seller\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ViewAction;

class ConfirmOrdersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Orders';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->whereIn('shipment_status', ['processing', 'shipping', 'arrived'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_code')->label('Order Code'),
                Tables\Columns\TextColumn::make('created_at')->label('TANGGAL'),
                Tables\Columns\BadgeColumn::make('shipment_status')
                    ->colors([
                        'warning' => 'processing',
                        'info' => 'shipping',
                        'success' => 'arrived',
                    ]),
                Tables\Columns\TextColumn::make('customerAddress.customer.FName')->label('CUSTOMER'),
                Tables\Columns\TextColumn::make('shipment_name')->label('PENGIRIMAN'),
            ])
            ->actions([
                ViewAction::make('view_products')
                    ->modalHeading('Daftar Produk')
                    ->modalContent(fn (Order $record) => view('order-products', ['order' => $record]))
                    ->modalWidth('lg'),
                Action::make('Mark as Shipped')
                    ->label('Shipping')
                    ->color('success')
                    ->action(function (Order $record) {
                        $record->shipment_status = 'shipping';
                        $record->save();
                        Notification::make()
                            ->title('Pesanan Ditandai Dikirim')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->shipment_status === 'processing'),
                Action::make('Mark as Arrived')
                    ->label('Arrived')
                    ->color('success')
                    ->action(function (Order $record) {
                        $record->shipment_status = 'arrived';
                        $record->save();
                        Notification::make()
                            ->title('Pesanan Ditandai Sampai')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->shipment_status === 'shipping'),
            ]);
    }
}
