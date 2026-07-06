<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'kode_barang',
        'name',
        'category_id',
        'stock',
        'location',
        'condition',
        'image'
    ];

    /**
     * Relasi ke kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke detail peminjaman
     */
    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}