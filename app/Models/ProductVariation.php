<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model
{
    use HasFactory;

    protected $primaryKey = 'variation_id';

    protected $fillable = [
        'product_id',
        'color',
        'material',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function photos()
    {
        return $this->hasMany(VariationPhoto::class, 'variation_id', 'variation_id');
    }
}
