<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $product = $this->record;
        $data['variations'] = $product->variations->map(function ($variation) {
            return [
                'id' => $variation->variation_id,
                'color' => $variation->color,
                'material' => $variation->material,
                'photos' => $variation->photos->pluck('directory')->toArray(),
                'sizes' => $variation->photos->flatMap(function ($photo) {
                    return $photo->sizes->map(function ($size) {
                        return [
                            'size' => $size->size,
                            'price' => $size->price,
                            'stock' => $size->stock,
                        ];
                    });
                })->toArray(),
            ];
        })->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            $record->update([
                'name' => $data['name'],
                'category_code' => $data['category_code'],
                'desc' => $data['desc'],
                'weight' => $data['weight'],
            ]);

            // Update or create variations
            foreach ($data['variations'] as $variationData) {
                $variation = $record->variations()->updateOrCreate(
                    ['variation_id' => $variationData['id'] ?? null],
                    [
                        'color' => $variationData['color'],
                        'material' => $variationData['material'],
                    ]
                );

                // Handle photos
                $photoIds = [];
                $photos = is_string($variationData['photos']) ? [$variationData['photos']] : $variationData['photos'];
                foreach ($photos as $photoPath) {
                    $photo = $variation->photos()->updateOrCreate(
                        ['directory' => $photoPath],
                        ['directory' => $photoPath]
                    );
                    $photoIds[] = $photo->photo_id;
                }
                // Delete photos not in the updated data
                $variation->photos()->whereNotIn('photo_id', $photoIds)->delete();

                // Handle sizes
                $sizeIds = [];
                foreach ($variationData['sizes'] as $sizeData) {
                    $size = $photo->sizes()->updateOrCreate(
                        ['size' => $sizeData['size']],
                        [
                            'price' => $sizeData['price'],
                            'stock' => $sizeData['stock'],
                        ]
                    );
                    $sizeIds[] = $size->id;
                }
                // Delete sizes not in the updated data
                $photo->sizes()->whereNotIn('variation_size_id', $sizeIds)->delete();
            }

            // Delete variations not in the updated data
            $variationIds = array_filter(array_column($data['variations'], 'id'));
            if (!empty($variationIds)) {
                $record->variations()->whereNotIn('variation_id', $variationIds)->delete();
            }

            return $record;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
