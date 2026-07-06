<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BorrowingExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
public function index(Request $request)
{
    $query = Borrowing::with([
        'user',
        'details.product'
    ]);

    // Search barang
    if ($request->filled('search')) {

        $query->whereHas('details.product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });

    }

    // Filter status
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    // Filter user
    if ($request->filled('user')) {

        $query->where('user_id', $request->user);

    }

    // Filter tanggal
    if ($request->filled('date')) {

        $query->whereDate('borrow_date', $request->date);

    }

$totalBorrowing = (clone $query)->count();

$totalApproved = (clone $query)
    ->where('status', 'approved')
    ->count();

$totalReturned = (clone $query)
    ->where('status', 'returned')
    ->count();

$totalRejected = (clone $query)
    ->where('status', 'rejected')
    ->count();

$borrowings = $query
    ->latest()
    ->paginate(10)
    ->withQueryString();

    return view('reports.index', [

        'borrowings'      => $borrowings,
        'users'           => User::all(),

        'totalBorrowing'  => $totalBorrowing,
        'totalApproved'   => $totalApproved,
        'totalReturned'   => $totalReturned,
        'totalRejected'   => $totalRejected,

    ]);
}

public function exportPdf(Request $request)
{
    $query = Borrowing::with(['user', 'details.product']);

    if ($request->search) {
        $query->whereHas('details.product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->user) {
        $query->where('user_id', $request->user);
    }

    if ($request->date) {
        $query->whereDate('borrow_date', $request->date);
    }

    $borrowings = $query
        ->latest()
        ->get();

    $pdf = Pdf::loadView('reports.pdf', compact('borrowings'));

    return $pdf->download('laporan-peminjaman.pdf');
}

public function exportExcel(Request $request)
{
    return Excel::download(
        new BorrowingExport($request),
        'laporan_peminjaman.xlsx'
    );
}
}