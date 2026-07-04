<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
        'product_id' => 'required',
        'quantity' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    //CEK STOK
    if ($product->stock < $request->quantity) {
        return back()->with('error', 'Stok tidak cukup!');
    }

    //SIMPAN PEMINJAMAN
    Borrowing::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'borrow_date' => now(),
    ]);

    //KURANGI STOK
    $product->decrement('stock', $request->quantity);

    return back()->with('success', 'Berhasil meminjam barang');
    }

    public function return($id)
    {
    $borrowing = Borrowing::findOrFail($id);

    if ($borrowing->status == 'returned') {
        return back()->with('error', 'Sudah dikembalikan');
    }

    // UPDATE STATUS
    $borrowing->update([
        'status' => 'returned',
        'return_date' => now()
    ]);

    // 🔥 TAMBAH STOK KEMBALI
    $borrowing->product->increment('stock', $borrowing->quantity);

    return back()->with('success', 'Barang dikembalikan');
    }
}
