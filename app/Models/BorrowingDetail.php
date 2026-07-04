<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetail extends Model
{
    public function borrowing()
    {
    return $this->belongsTo(Borrowing::class);
    }

    public function product()
    {
    return $this->belongsTo(Product::class);
    }
}
