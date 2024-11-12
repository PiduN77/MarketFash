<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationPhoto;
use App\Models\VariationSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('variations', 'variations.photos', 'variations.photos.sizes', 'shop', 'category')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Shop',
            'Category',
            'Description',
            'Weight',
            'Status',
            'Variation - Color',
            'Variation - Material',
            'Variation - Price',
            'Variation - Stock',
            'Variation Photo - Directory',
            'Variation Size - Size',
            'Variation Size - Price',
            'Variation Size - Stock',
        ];
    }

    public function map($product): array
    {
        
        $mapped = [];
        foreach ($product->variations as $variation) {
            
            foreach ($variation->photos as $photo) {
                foreach ($photo->sizes as $size) {
                    $mapped[] = [
                        $product->name,
                        optional($product->shop)->name,
                        optional($product->category)->name,
                        $product->desc,
                        $product->weight,
                        $product->status,
                        $variation->color,
                        $variation->material,
                        $size->price,
                        $size->stock,
                        $photo->directory,
                        $size->size,
                        $size->price,
                        $size->stock,
                    ];
                }
            }
        }
        return $mapped;
    }
}
