<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Informasi Produk')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Produk')
                                ->required()
                                ->placeholder('Nama produk')
                                ->columnSpan('full'),
                            Select::make('category_code')
                                ->label('Kategori')
                                ->options(Category::all()->pluck('name', 'category_code')->toArray())
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn($state, callable $set) => $set('variations', []))
                                ->columnSpan(2),
                            TextInput::make('weight')
                                ->label('Berat')
                                ->numeric()
                                ->required()
                                ->suffix('g')
                                ->placeholder('0'),
                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(3)
                                ->required()
                                ->placeholder('Deskripsi produk')
                                ->columnSpan(3),
                        ])->columns(3),

                    Wizard\Step::make('Variasi Produk')
                        ->schema([
                            Repeater::make('variations')
                                ->label('Variasi Produk')
                                ->schema([
                                    TextInput::make('color')
                                        ->label('Warna')
                                        ->required()
                                        ->placeholder('Masukkan warna')
                                        ->columnSpan(2),
                                    TextInput::make('material')
                                        ->label('Material')
                                        ->required()
                                        ->placeholder('Masukkan nama material'),
                                    FileUpload::make('photos')
                                        ->label('Foto Produk')
                                        ->image()
                                        ->disk('public')
                                        ->visibility('public')
                                        ->required()
                                        ->panelLayout('grid')
                                        ->directory('product-photos')
                                        ->columnSpan(3),
                                    Repeater::make('sizes')
                                        ->label('Ukuran dan Stok')
                                        ->schema([
                                            Select::make('size')
                                                ->label('Ukuran')
                                                ->options(fn($get) => $get('../../../../category_code') === 'SHS'
                                                    ? array_combine(range(30, 45), range(30, 45))
                                                    : ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL'])
                                                ->required()
                                                ->columnSpan(1),
                                            TextInput::make('price')
                                                ->label('Harga')
                                                ->required()
                                                ->prefix('Rp'),
                                            TextInput::make('stock')
                                                ->label('Stok')
                                                ->required()
                                                ->numeric(),
                                        ])
                                        ->columns(3)
                                        ->columnSpan(3)
                                        ->createItemButtonLabel('Tambah Ukuran')
                                ])
                                ->collapsible()
                                ->defaultItems(1)
                                ->columns(3)
                                ->createItemButtonLabel('Tambah Variasi Warna')
                        ]),
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()->where('shop_id', Auth::user()->customers->sellers->shops->shop_id)
            )
            ->columns([
                ImageColumn::make('variations.photos.directory')
                    ->label('Foto Produk')
                    ->getStateUsing(function ($record) {
                        $photo = $record->variations->first()?->photos->first()?->directory;
                        return $photo ? asset('storage/' . $photo) : null;
                    })
                    ->size(50)
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('desc')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->desc),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'success' => 'Publish',
                        'info' => 'Draft',
                    ]),

                TextColumn::make('variations_count')
                    ->label('Jumlah Variasi')
                    ->counts('variations')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
                Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->iconButton()
                    ->action(function (Product $record) {
                        $record->status = 'Publish';
                        $record->save();
                        Notification::make()
                            ->title('Product Published')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->hidden(fn(Product $record) => $record->status === 'Publish'),
                Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->iconButton()
                    ->action(function (Product $record) {
                        $record->status = 'Draft';
                        $record->save();
                        Notification::make()
                            ->title('Product Unpublished')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->hidden(fn(Product $record) => $record->status !== 'Publish'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
