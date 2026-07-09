<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Borrowing;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [];

        // LOW STOCK
        $lowStockItems = Product::where('stock', '<=', config('app.low_stock', 5))
            ->orderBy('stock')
            ->take(5)
            ->get();

        foreach ($lowStockItems as $item) {
            $notifications[] = [
                'title'   => 'Low Stock',
                'message' => $item->name . ' tersisa ' . $item->stock,
                'url'     => route('products.index'),
            ];
        }

        // HANYA ADMIN / STAFF
        if (auth()->user()->hasRole(['admin', 'staff'])) {

            $pendingBorrowings = Borrowing::with('user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            foreach ($pendingBorrowings as $item) {
                $notifications[] = [
                    'title'   => 'Borrow Request',
                    'message' => optional($item->user)->name . ' mengajukan peminjaman',
                    'url'     => route('borrowings.index'),
                ];
            }
        }

        return response()->json([
            'count' => count($notifications),
            'data'  => $notifications,
        ]);
    }
}