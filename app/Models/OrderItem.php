<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_item_id';

    protected $fillable = [
        'variation_size_id',
        'order_code',
        'qty',
    ];

    public function variationSize()
    {
        return $this->belongsTo(VariationSize::class, 'variation_size_id', 'variation_size_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_code', 'order_code');
    }
}
