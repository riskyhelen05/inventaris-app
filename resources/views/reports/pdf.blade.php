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
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
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

        .footer{
            margin-top:30px;
            text-align:right;
            font-size:11px;
        }

    </style>

</head>

<body>

<h2>
    Laporan Peminjaman Barang
</h2>

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

    @foreach($borrowings as $borrowing)

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

    @endforeach

    </tbody>

</table>

<div class="footer">

    Dicetak pada :
    {{ now()->format('d/m/Y H:i') }}

</div>

</body>

</html>