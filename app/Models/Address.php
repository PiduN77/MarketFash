<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kodepos'
    ];

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class, 'address_id', 'address_id');
    }
}