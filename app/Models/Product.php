<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'nama',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
        'stok'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
