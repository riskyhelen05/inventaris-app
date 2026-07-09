<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            BorrowingDetail::class,
            'borrowing_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'  => 'Menunggu',
            'approved' => 'Disetujui',
            'returned' => 'Dikembalikan',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }
}