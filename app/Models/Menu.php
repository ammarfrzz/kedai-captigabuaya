<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'kategori',
        'nama',
        'slug',
        'harga',
        'terlaris',
        'label',
        'rating',
        'ulasan',
        'deskripsi',
        'gambar',
        'is_available',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'terlaris' => 'boolean',
        'rating' => 'float',
        'ulasan' => 'integer',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
