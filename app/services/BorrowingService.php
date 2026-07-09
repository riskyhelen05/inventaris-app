<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    const PENDING  = 'pending';
    const APPROVED = 'approved';
    const RETURNED = 'returned';
    const REJECTED = 'rejected';

    public function borrow($request)
    {
        return DB::transaction(function () use ($request) {

            if (empty($request->products)) {
                throw new \Exception('Tidak ada produk dipilih.');
            }

            $borrowing = Borrowing::create([
                'user_id'     => Auth::id(),
                'borrow_date' => now(),
                'status'      => self::PENDING,
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

    public function approve(Borrowing $borrowing)
    {
        return DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::lockForUpdate()
                ->findOrFail($borrowing->id);

            $borrowing->loadMissing('details');

            if ($borrowing->status !== self::PENDING) {
                throw new \Exception('Peminjaman sudah diproses.');
            }

            foreach ($borrowing->details as $detail) {

                $product = Product::lockForUpdate()
                    ->findOrFail($detail->product_id);

                if ($product->stock < $detail->quantity) {
                    throw new \Exception(
                        "Stok {$product->name} tidak cukup."
                    );
                }

                $product->decrement('stock', $detail->quantity);
            }

            $borrowing->update([
                'status' => self::APPROVED
            ]);

            return $borrowing;
        });
    }

    public function returnItem(Borrowing $borrowing)
    {
        return DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::lockForUpdate()
                ->findOrFail($borrowing->id);

            $borrowing->loadMissing('details');

            if ($borrowing->status !== self::APPROVED) {
                throw new \Exception('Barang belum dapat dikembalikan.');
            }

            foreach ($borrowing->details as $detail) {

                $product = Product::lockForUpdate()
                    ->findOrFail($detail->product_id);

                $product->increment('stock', $detail->quantity);
            }

            $borrowing->update([
                'status'      => self::RETURNED,
                'return_date' => now(),
            ]);

            return $borrowing;
        });
    }

    public function reject(Borrowing $borrowing)
    {
        return DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::lockForUpdate()
                ->findOrFail($borrowing->id);

            if ($borrowing->status !== self::PENDING) {
                throw new \Exception('Peminjaman sudah diproses.');
            }

            $borrowing->update([
                'status' => self::REJECTED
            ]);

            return $borrowing;
        });
    }
}