<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationPhoto;
use App\Models\VariationSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
                'name' => $data['name'],
                'shop_id' => Auth::user()->customers->sellers->shops->shop_id,
                'category_code' => $data['category_code'],
                'desc' => $data['desc'],
                'weight' => $data['weight'],
                'status' => 'Draft',
            ]);

            foreach ($data['variations'] as $variationData) {
                $variation = ProductVariation::create([
                    'product_id' => $product->product_id,
                    'color' => $variationData['color'],
                    'material' => $variationData['material'],
                ]);

                $photos = is_string($variationData['photos']) ? [$variationData['photos']] : $variationData['photos'];

                foreach ($photos as $photo) {
                    $variationPhoto = VariationPhoto::create([
                        'variation_id' => $variation->variation_id,
                        'directory' => $photo,
                    ]);
                }

                foreach ($variationData['sizes'] as $sizeData) {
                    VariationSize::create([
                        'photo_id' => $variationPhoto->photo_id,
                        'size' => $sizeData['size'],
                        'price' => $sizeData['price'],
                        'stock' => $sizeData['stock'],
                    ]);
                }
            }

            return $product;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
