<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Peminjaman</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#374151;
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:25px;
    border-bottom:2px solid #111827;
    padding-bottom:10px;
}

.header h2{
    margin:0;
    font-size:18px;
    letter-spacing:0.5px;
}

.subtitle{
    font-size:11px;
    color:#6b7280;
    margin-top:4px;
}

/* INFO */
.info{
    margin-bottom:15px;
    font-size:11px;
    line-height:1.7;
}

.info strong{
    display:inline-block;
    width:130px;
    color:#111827;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

thead th{
    background:#f9fafb;
    color:#111827;
    font-size:11px;
    text-transform:uppercase;
    border-bottom:2px solid #d1d5db;
    padding:9px 6px;
}

th.text-left {
    text-align: left;
}

th.text-center {
    text-align: center;
}

tbody td{
    padding:8px 6px;
    border-bottom:1px solid #e5e7eb;
}

tbody tr:nth-child(even){
    background:#f9fafb;
}

.center{
    text-align:center;
}

/* STATUS BADGE */
.badge{
    display:inline-block;
    padding:3px 8px;
    border-radius:6px;
    font-size:10px;
    font-weight:bold;
}

.pending{
    background:#fef3c7;
    color:#92400e;
}

.approved{
    background:#dbeafe;
    color:#1e40af;
}

.returned{
    background:#d1fae5;
    color:#065f46;
}

.rejected{
    background:#fee2e2;
    color:#991b1b;
}

/* EMPTY STATE */
.empty{
    padding:20px;
    text-align:center;
    color:#9ca3af;
}

/* FOOTER */
.footer{
    margin-top:40px;
    border-top:1px solid #e5e7eb;
    padding-top:12px;
    text-align:center;
    font-size:11px;
    color:#6b7280;
    line-height:1.6;
}

</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>Laporan Peminjaman Barang</h2>
    <div class="subtitle">Sistem Inventaris Barang</div>
</div>

<!-- INFO -->
<div class="info">
    <strong>Tanggal Cetak</strong> : {{ now()->format('d/m/Y H:i') }} <br>
    <strong>Total Data</strong> : {{ $borrowings->count() }}
</div>

<!-- TABLE -->
<table>

    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-left">Peminjam</th>
            <th class="text-left">Barang</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tanggal</th>
        </tr>
    </thead>

    <tbody>

    @php $no = 1; @endphp

    @forelse($borrowings as $borrowing)

        @foreach($borrowing->details as $detail)

        <tr>

            <td class="center">{{ $no++ }}</td>

            <td>{{ $borrowing->user->name }}</td>

            <td>{{ $detail->product->name }}</td>

            <td class="center">{{ $detail->quantity }}</td>

            <td class="center">
                <span class="badge {{ $borrowing->status }}">
                    {{ ucfirst($borrowing->status) }}
                </span>
            </td>

            <td class="center">
                {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}
            </td>

        </tr>

        @endforeach

    @empty

        <tr>
            <td colspan="6" class="empty">
                Tidak ada data peminjaman
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

<!-- FOOTER -->
<div class="footer">
    Dicetak pada {{ now()->format('d M Y H:i') }} <br>
    Sistem Inventaris © {{ date('Y') }}
</div>

</body>
</html>