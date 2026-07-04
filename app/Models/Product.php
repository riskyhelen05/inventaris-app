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

    public function category()
    {
    return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
    return $this->hasMany(Borrowing::class);
    }
}
