<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'price',
        'description',
        'image',
        'stock',
        'status',
        // Old columns for backward compatibility
        'nama',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
        'stok',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'harga' => 'decimal:2',
        'stock' => 'integer',
        'stok' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('approved', true);
    }

    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }
}
