<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    /**
     * Ajukan peminjaman
     */
    public function borrow($request)
    {
        return DB::transaction(function () use ($request) {

            $borrowing = Borrowing::create([
                'user_id'     => Auth::id(),
                'borrow_date' => now(),
                'status'      => 'pending',
            ]);

            foreach ($request->products as $item) {

                $product = Product::lockForUpdate()
                    ->findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    throw new \Exception(
                        "Stok {$product->name} tidak cukup."
                    );
                }

                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'product_id'   => $product->id,
                    'quantity'     => $item['qty'],
                ]);
            }

            return $borrowing->load('details.product');
        });
    }

    /**
     * Approve peminjaman
     */
    public function approve(Borrowing $borrowing)
    {
        return DB::transaction(function () use ($borrowing) {

            foreach ($borrowing->details as $detail) {

                $product = Product::lockForUpdate()
                    ->findOrFail($detail->product_id);

                if ($product->stock < $detail->quantity) {
                    throw new \Exception(
                        "Stok {$product->name} tidak cukup."
                    );
                }

                $product->decrement(
                    'stock',
                    $detail->quantity
                );
            }

            $borrowing->update([
                'status' => 'approved'
            ]);

            return $borrowing;
        });
    }

    /**
     * Return barang
     */
    public function returnItem(Borrowing $borrowing)
    {
        return DB::transaction(function () use ($borrowing) {

            if ($borrowing->status !== 'approved') {
                throw new \Exception(
                    'Barang belum dapat dikembalikan.'
                );
            }

            foreach ($borrowing->details as $detail) {

                $product = Product::lockForUpdate()
                    ->findOrFail($detail->product_id);

                $product->increment(
                    'stock',
                    $detail->quantity
                );
            }

            $borrowing->update([
                'status'      => 'returned',
                'return_date' => now(),
            ]);

            return $borrowing;
        });
    }
}