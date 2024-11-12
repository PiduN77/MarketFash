<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\search;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('Order Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customerAddress.customer.FName')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->money('IDR')
                    ->label('Total')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_name')
                    ->label('Payment')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->label('Payment status')
                    ->sortable()
                    ->searchable(),
                SelectColumn::make('shipment_status')
                    ->options([
                        null => 'New',
                        'processing' => 'Processing',
                        'shipping' => 'Shipping',
                        'arrived' => 'arrived',
                        'cancelled' => 'cancelled',
                    ])
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orderItems.variationSize.photo.variation.product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_name')
                    ->label('Shipment')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Action::make('Confirm Pesanan')
                //     ->label('Konfirmasi Pesanan')
                //     ->icon('heroicon-o-check-circle')
                //     ->color('success')
                //     ->iconButton()
                //     ->action(function (Order $record) {
                //         $record->shipment_status = 'processing';
                //         $record->save();
                //         Notification::make()
                //             ->title('Pesanan Dikonfirmasi')
                //             ->success()
                //             ->send();
                //     })
                //     ->requiresConfirmation()
                //     ->hidden(fn(Order $record) => $record->status === 'processing'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
        ];
    }
}
