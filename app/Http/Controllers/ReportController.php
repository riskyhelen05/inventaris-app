<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BorrowingExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Borrowing::with(['user', 'details.product']);

        $query = $this->applyFilters(clone $baseQuery, $request);

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('reports.index', [
            'borrowings' => $borrowings,
            'users' => User::select('id','name')->get(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Borrowing::with(['user', 'details.product']);

        $query = $this->applyFilters($query, $request);

        // BATASI DATA
        $borrowings = $query->latest()->limit(500)->get();

        if ($borrowings->count() === 0) {
            return back()->with('error', 'Tidak ada data untuk export');
        }

        $pdf = Pdf::loadView('reports.pdf', compact('borrowings'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BorrowingExport($request),
            'laporan_peminjaman.xlsx'
        );
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('search')) {
            $query->whereHas('details.product', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('date')) {
            $query->whereDate('borrow_date', $request->date);
        }

        return $query;
}
}