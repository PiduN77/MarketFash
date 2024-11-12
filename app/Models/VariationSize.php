<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationSize extends Model
{
    use HasFactory;

    protected $primaryKey = 'variation_size_id';

    protected $fillable = [
        'photo_id',
        'size',
        'price',
        'stock',
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(VariationPhoto::class, 'photo_id', 'photo_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'variation_size_id', 'variation_size_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'variation_size_id', 'variation_size_id');
    }
}
