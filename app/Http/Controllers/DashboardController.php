<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::query();

        // FILTER
        if ($request->month) {
            $query->whereMonth('borrow_date', date('m', strtotime($request->month)));
        }

        if ($request->user) {
            $query->where('user_id', $request->user);
        }

        if ($request->product) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->where('product_id', $request->product);
    });
}

        // LINE CHART
        $chartData = $query
            ->selectRaw('DATE(borrow_date) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // PIE CHART
        $pieData = BorrowingDetail::when($request->product, function ($q) use ($request) {
        $q->where('product_id', $request->product);
        })
            ->selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->with('product')
            ->get()
            ->map(fn($item) => [
        'product' => $item->product->name ?? '-',
        'total' => $item->total
        ]);

        // BAR CHART
        $stockData = Product::select('name as product', 'stock')->get();

// LOW STOCK
$lowStocks = Product::where('stock', '<=', 5)
    ->orderBy('stock')
    ->take(5)
    ->get();

// TOP BORROWED
$topBorrowed = BorrowingDetail::with('product')
    ->selectRaw('product_id, SUM(quantity) as total')
    ->groupBy('product_id')
    ->orderByDesc('total')
    ->take(5)
    ->get();

// RECENT ACTIVITY
$recentActivities = ActivityLog::with('user')
    ->latest()
    ->take(5)
    ->get();

return view('dashboard', [

    'chartData' => $chartData,
    'pieData' => $pieData,
    'stockData' => $stockData,

    'users' => User::all(),
    'products' => Product::all(),

    'totalBarang' => Product::count(),

    'barangDipinjam' => Borrowing::where('status','approved')->count(),

    'barangTersedia' => Product::sum('stock'),

    'lowStocks' => $lowStocks,

    'topBorrowed' => $topBorrowed,

    'recentActivities' => $recentActivities,

]);
    }

    public function activityLogs()
    {
    $logs = \App\Models\ActivityLog::with('user')
        ->latest()
        ->paginate(10);

    return view('activity_logs.index', compact('logs'));
    }
}