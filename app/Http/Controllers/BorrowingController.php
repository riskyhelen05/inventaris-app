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
    }

    /**
     * List Borrowing + Search + Filter
     */
public function index(Request $request)
{
    $query = Borrowing::with([
        'user',
        'details.product'
    ]);

    // Search Barang
    if ($request->filled('search')) {
        $query->whereHas('details.product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // Filter Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter User
    if ($request->filled('user')) {
        $query->where('user_id', $request->user);
    }

    // Filter Tanggal
    if ($request->filled('date')) {
        $query->whereDate('borrow_date', $request->date);
    }

    $borrowings = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $users = \App\Models\User::orderBy('name')->get();

    return view(
        'borrowings.index',
        compact(
            'borrowings',
            'users'
        )
    );
}
    /**
     * Form Create Borrowing
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();

        return view('borrowings.create', compact('products'));
    }

    /**
     * Store Borrowing
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        try {

            $borrowing = $this->service->borrow($request);

            $borrowing->load('details.product');

            $productNames = $borrowing->details
                ->map(fn($d) => $d->product->name . ' (x' . $d->quantity . ')')
                ->implode(', ');

            ActivityLogger::borrow($productNames);

            return redirect()
                ->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil diajukan.');

        } catch (\Throwable $e) {

            return back()->with('error', $e->getMessage());

        }
    }

    /**
     * Detail Borrowing
     */
    public function show($id)
    {
        $borrowing = Borrowing::with([
            'user',
            'details.product'
        ])->findOrFail($id);

        return view(
            'borrowings.show',
            compact('borrowing')
        );
    }

    /**
     * Approve Borrowing
     */
    public function approve($id)
    {
        try {

            $borrowing = Borrowing::with('details.product')
                ->findOrFail($id);

            if ($borrowing->status != 'pending') {
                return back()->with(
                    'error',
                    'Peminjaman sudah diproses.'
                );
            }

            $this->service->approve($borrowing);

            $productNames = $borrowing->details
                ->map(fn($d) => $d->product->name)
                ->implode(', ');

            ActivityLogger::approve($productNames);

            return back()->with(
                'success',
                'Peminjaman berhasil disetujui.'
            );

        } catch (\Throwable $e) {

            return back()->with('error', $e->getMessage());

        }
    }

    /**
     * Reject Borrowing
     */
    public function reject($id)
    {
        $borrowing = Borrowing::with('details.product')
            ->findOrFail($id);

        if ($borrowing->status != 'pending') {
            return back()->with(
                'error',
                'Peminjaman sudah diproses.'
            );
        }

        $borrowing->update([
            'status' => 'rejected'
        ]);

        $productNames = $borrowing->details
            ->map(fn($d) => $d->product->name)
            ->implode(', ');

        ActivityLogger::reject($productNames);

        return back()->with(
            'success',
            'Peminjaman berhasil ditolak.'
        );
    }

    /**
     * Return Borrowing
     */
    public function returnItem($id)
    {
        try {

            $borrowing = Borrowing::with('details.product')
                ->findOrFail($id);

            if ($borrowing->status != 'approved') {
                return back()->with(
                    'error',
                    'Barang belum disetujui atau sudah dikembalikan.'
                );
            }

            $this->service->returnItem($borrowing);

            $productNames = $borrowing->details
                ->map(fn($d) => $d->product->name)
                ->implode(', ');

            ActivityLogger::returned($productNames);

            return back()->with(
                'success',
                'Barang berhasil dikembalikan.'
            );

        } catch (\Throwable $e) {

            return back()->with('error', $e->getMessage());

        }
    }
}