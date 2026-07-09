<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // semua user boleh lihat, tapi nanti bisa dibedakan
        $this->middleware('auth');
    }

public function index(Request $request)
{
    // ================= FILTER =================
    $baseQuery = Borrowing::query();

    if ($request->month) {
        $baseQuery->whereMonth('borrow_date', date('m', strtotime($request->month)));
    }

    if ($request->user) {
        $baseQuery->where('user_id', $request->user);
    }

    if ($request->product) {
        $baseQuery->whereHas('details', function ($q) use ($request) {
            $q->where('product_id', $request->product);
        });
    }

    // ================= CHART =================
    $months = collect([
        1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',
        7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
    ]);

    $chartRaw = (clone $baseQuery)
        ->selectRaw('MONTH(borrow_date) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total','month');

    $chartData = $months->map(function ($name, $month) use ($chartRaw) {
        return [
            'date' => $name,
            'total' => $chartRaw[$month] ?? 0
        ];
    })->values();

    $stockData = DB::table('borrowing_details')
    ->selectRaw('products.name as product, SUM(borrowing_details.quantity) as total')
    ->join('products', 'borrowing_details.product_id', '=', 'products.id')
    ->groupBy('products.name')
    ->orderByDesc('total')
    ->limit(5)
    ->get()
    ->values()
    ->map(function ($item, $index) {
        $item->rank = $index + 1;
        return $item;
    });

// ================= STATISTIK =================

// ===== BARANG DIPINJAM (HARUS DI ATAS) =====
$barangDipinjam = \App\Models\BorrowingDetail::join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
    ->where('borrowings.status', 'approved') // masih dipinjam
    ->sum('borrowing_details.quantity');

// ===== BARANG =====
$totalBarang   = \App\Models\Product::count();
$barangTersedia = Product::sum('stock');

$stokHabis     = \App\Models\Product::where('stock', 0)->count();
$totalKategori = \App\Models\Product::distinct('category_id')->count('category_id');

// ===== PEMINJAMAN =====
$totalBorrowing = \App\Models\Borrowing::count();
$totalPending   = \App\Models\Borrowing::where('status', 'pending')->count();
$totalApproved  = \App\Models\Borrowing::where('status', 'approved')->count();
$totalReturned  = \App\Models\Borrowing::where('status', 'returned')->count();
$totalRejected  = \App\Models\Borrowing::where('status', 'rejected')->count();

// ================= LOW STOCK =================
$lowStocks = \App\Models\Product::where('stock', '<=', config('app.low_stock', 5))
    ->orderBy('stock')
    ->take(5)
    ->get();

// ================= RECENT ACTIVITY =================
$recentActivities = DB::table('borrowing_details')
    ->join('borrowings', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
    ->join('users', 'borrowings.user_id', '=', 'users.id')
    ->join('products', 'borrowing_details.product_id', '=', 'products.id')
    ->orderByDesc('borrowing_details.created_at')
    ->limit(5)
    ->get([
        'users.name as user',
        'products.name as product',
        'borrowing_details.quantity',
        'borrowings.status',
        'borrowing_details.created_at'
    ]);

// ================= RETURN VIEW =================
return view('dashboard', compact(
    'chartData',
    'stockData',

    'totalBarang',     
    'barangTersedia',
    'barangDipinjam',
    'stokHabis',
    'totalKategori',

    'totalBorrowing',
    'totalPending',
    'totalApproved',
    'totalReturned',
    'totalRejected',

    'lowStocks',
    'recentActivities'
));

}

    public function activityLogs()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(10);

        return view('activity_logs.index', compact('logs'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');

        if (!$keyword) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('kode_barang', 'like', "%{$keyword}%")
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'Barang',
                'title' => $item->name,
                'url' => route('products.index') . '?search=' . urlencode($item->name),
            ]);

        $categories = \App\Models\Category::where('name', 'like', "%{$keyword}%")
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'Kategori',
                'title' => $item->name,
                'url' => route('categories.index') . '?search=' . urlencode($item->name),
            ]);

        $borrowings = Borrowing::with('user')
            ->whereHas('user', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'type' => 'Peminjaman',
                'title' => 'Peminjaman oleh ' . optional($item->user)->name,
                'url' => route('borrowings.index'),
            ]);

        return response()->json(
            $products->concat($categories)->concat($borrowings)->values()
        );
    }

    public function notifications()
    {
        $notifications = [];

        // LOW STOCK
        foreach (Product::where('stock', '<=', config('app.low_stock', 5))->take(5)->get() as $product) {
            $notifications[] = [
                'title' => 'Low Stock',
                'message' => $product->name . ' tersisa ' . $product->stock,
                'url' => route('products.index'),
            ];
        }

        // hanya admin/staff lihat request
        if (auth()->user()->hasRole(['admin','staff'])) {
            foreach (Borrowing::with('user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get() as $borrow) {

                $notifications[] = [
                    'title' => 'Borrow Request',
                    'message' => optional($borrow->user)->name . ' mengajukan peminjaman',
                    'url' => route('borrowings.index'),
                ];
            }
        }

        return response()->json([
            'count' => count($notifications),
            'data' => $notifications,
        ]);
    }
}