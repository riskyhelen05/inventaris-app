<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Peminjaman</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:2px;
        }

        .subtitle{
            text-align:center;
            margin-bottom:20px;
            font-size:11px;
            color:#555;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }

        th{
            background:#e5e5e5;
        }

        .center{
            text-align:center;
        }

        .info{
            margin-bottom:15px;
            font-size:11px;
        }

        .footer{
            margin-top:25px;
            text-align:right;
            font-size:11px;
        }

    </style>

</head>

<body>

<h2>Laporan Peminjaman Barang</h2>

<div class="subtitle">
    Sistem Inventaris Barang
</div>

<div class="info">

    <strong>Tanggal Cetak :</strong>
    {{ now()->format('d/m/Y H:i') }}
    <br>

    <strong>Total Data :</strong>
    {{ $borrowings->count() }}

</div>

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Peminjam</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Tanggal</th>

        </tr>

    </thead>

    <tbody>

    @php
        $no = 1;
    @endphp

    @forelse($borrowings as $borrowing)

        @foreach($borrowing->details as $detail)

        <tr>

            <td class="center">
                {{ $no++ }}
            </td>

            <td>
                {{ $borrowing->user->name }}
            </td>

            <td>
                {{ $detail->product->name }}
            </td>

            <td class="center">
                {{ $detail->quantity }}
            </td>

            <td class="center">
                {{ ucfirst($borrowing->status) }}
            </td>

            <td class="center">
                {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}
            </td>

        </tr>

        @endforeach

    @empty

        <tr>

            <td colspan="6" class="center">
                Tidak ada data.
            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<div class="footer">

    Dicetak otomatis oleh Sistem Inventaris Barang

</div>

</body>

</html>