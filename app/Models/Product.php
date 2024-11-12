<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'shop_id',
        'category_code',
        'desc',
        'weight',
        'status',
    ];

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'product_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_code', 'category_code');
    }
    
}
