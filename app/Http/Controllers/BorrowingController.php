<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use App\Models\Product;
use App\Models\User;
use App\Services\BorrowingService;
use App\Helpers\ActivityLogger;

class BorrowingController extends Controller
{
    protected $service;

    public function __construct(BorrowingService $service)
    {
        $this->service = $service;

        $this->middleware('auth');

        $this->middleware('role:admin|staff|manager')->only([
            'approve',
            'reject',
            'returnItem'
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['admin','staff','manager']);

        $query = Borrowing::with([
            'user:id,name',
            'details.product:id,name,stock'
        ]);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('search')) {
            $query->whereHas('details.product', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user') && $isAdmin) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('date')) {
            $query->whereDate('borrow_date', $request->date);
        }

        $borrowings = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $users = $isAdmin
            ? User::select('id','name')->orderBy('name')->get()
            : [];

        return view('borrowings.index', compact('borrowings','users'));
    }

    public function create()
    {
        $products = Product::select('id','name','stock')
            ->where('stock','>',0)
            ->limit(100)
            ->get();

        return view('borrowings.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        try {
            $borrowing = $this->service->borrow($request);

            $borrowing->load('details.product:id,name,stock');

            $productNames = $borrowing->details
                ->map(fn($d) => "{$d->product->name} (x{$d->quantity})")
                ->implode(', ');

            ActivityLogger::borrow($productNames);

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil diajukan.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $borrowing = Borrowing::with([
            'user:id,name',
            'details.product:id,name,stock' // ✅ TAMBAHKAN stock
        ])->findOrFail($id);

        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['admin','staff','manager']);

        if (!$isAdmin && $borrowing->user_id !== $user->id) {
            abort(403);
        }

        return view('borrowings.show', compact('borrowing'));
    }

    public function approve($id)
    {
        try {
            $borrowing = Borrowing::with('details.product')->findOrFail($id);

            if ($borrowing->status !== 'pending') {
                return back()->with('error', 'Peminjaman sudah diproses.');
            }

            $this->service->approve($borrowing);

            ActivityLogger::approve(
                $borrowing->details->pluck('product.name')->implode(', ')
            );

            return back()->with('success', 'Peminjaman disetujui.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $borrowing = Borrowing::with('details.product')->findOrFail($id);

            if ($borrowing->status !== 'pending') {
                return back()->with('error', 'Peminjaman sudah diproses.');
            }

            $this->service->reject($borrowing); // 🔥 pindah ke service

            ActivityLogger::log(
                'reject',
                "Menolak: ".$borrowing->details->pluck('product.name')->implode(', ')
            );

            return back()->with('success', 'Ditolak.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function returnItem($id)
    {
        try {
            $borrowing = Borrowing::with('details.product')->findOrFail($id);

            if ($borrowing->status !== 'approved') {
                return back()->with('error', 'Belum bisa dikembalikan.');
            }

            $this->service->returnItem($borrowing);

            ActivityLogger::returned(
                $borrowing->details->pluck('product.name')->implode(', ')
            );

            return back()->with('success', 'Berhasil dikembalikan.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}