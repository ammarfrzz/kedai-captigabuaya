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

    /**
     * Accessor untuk gambar menu agar selalu valid di berbagai domain / port
     * dan memiliki fallback image jika file tidak ditemukan atau kosong.
     */
    public function getGambarAttribute($value)
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80';
        }

        // Jika URL eksternal (Unsplash, dll) yang bukan localhost
        if (preg_match('#^https?://#i', $value)) {
            if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/(.*)$#i', $value, $matches)) {
                $relativePath = ltrim($matches[3], '/');
                return asset($relativePath);
            }
            return $value;
        }

        // Jika path relatif (misal: images/menus/filename.jpg)
        return asset(ltrim($value, '/'));
    }
}
