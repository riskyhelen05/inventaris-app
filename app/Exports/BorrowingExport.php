<?php

namespace App\Exports;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class BorrowingExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Borrowing::with(['user', 'details.product']);

        // Search barang
        if ($this->request->filled('search')) {
            $search = $this->request->search;

            $query->whereHas('details.product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        // Filter user
        if ($this->request->filled('user')) {
            $query->where('user_id', $this->request->user);
        }

        // Filter tanggal
        if ($this->request->filled('date')) {
            $query->whereDate('borrow_date', $this->request->date);
        }

        $borrowings = $query->latest()->get();

        $rows = collect();

        foreach ($borrowings as $borrowing) {
            foreach ($borrowing->details as $detail) {

                $rows->push([
                    // Nama user aman
                    optional($borrowing->user)->name ?? '-',

                    // Nama barang aman
                    optional($detail->product)->name ?? '-',

                    // Qty aman
                    $detail->quantity ?? 0,

                    // Status aman
                    ucfirst($borrowing->status ?? '-'),

                    // Format tanggal
                    $borrowing->borrow_date
                        ? Carbon::parse($borrowing->borrow_date)->format('d-m-Y')
                        : '-',
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Peminjam',
            'Barang',
            'Qty',
            'Status',
            'Tanggal',
        ];
    }
}