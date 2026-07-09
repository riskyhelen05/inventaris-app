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

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function getConditionLabelAttribute()
    {
        return match ($this->condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            default => ucfirst(str_replace('_', ' ', $this->condition)),
        };
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}