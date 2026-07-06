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

    // 🔗 relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 relasi ke detail (INI YANG PENTING)
    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}