<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationPhoto extends Model
{
    use HasFactory;

    protected $primaryKey = 'photo_id';

    protected $fillable = [
        'variation_id',
        'directory',
    ];

    // Relasi ke ProductVariation
    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id', 'variation_id');
    }

    public function sizes()
    {
        return $this->hasMany(VariationSize::class, 'photo_id', 'photo_id');
    }
}
