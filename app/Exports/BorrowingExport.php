<?php

namespace App\Exports;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BorrowingExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Borrowing::with([
            'user',
            'details.product'
        ]);

        // Search barang
        if ($this->request->filled('search')) {
            $query->whereHas('details.product', function ($q) {
                $q->where('name', 'like', '%' . $this->request->search . '%');
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

                    $borrowing->user->name,

                    $detail->product->name,

                    $detail->quantity,

                    ucfirst($borrowing->status),

                    $borrowing->borrow_date,

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