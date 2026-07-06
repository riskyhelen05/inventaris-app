<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BorrowingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $rows = collect();

        $borrowings = Borrowing::with(['user', 'details.product'])->get();

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