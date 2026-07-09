<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans;
    margin:30px;
    color:#1e293b;
}

/* HEADER */
.header{
    text-align:center;
    border-bottom:2px solid #dc2626;
    padding-bottom:12px;
    margin-bottom:25px;
}

.header h1{
    margin:0;
    color:#dc2626;
    font-size:26px;
}

.header p{
    margin:4px 0 0;
    color:#64748b;
    font-size:13px;
}

/* LAYOUT */
.container{
    width:100%;
}

.left{
    width:60%;
    float:left;
}

.right{
    width:35%;
    float:right;
    text-align:center;
}

/* TITLE */
.product-title{
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
}

td{
    padding:7px 4px;
    border-bottom:1px solid #e2e8f0;
}

.label{
    width:130px;
    font-weight:bold;
    color:#475569;
}

/* BADGE */
.badge{
    display:inline-block;
    background:#dc2626;
    color:white;
    padding:3px 10px;
    border-radius:12px;
    font-size:11px;
}

/* QR */
.qr{
    border:1px solid #e2e8f0;
    padding:10px;
    border-radius:8px;
}

/* QR TEXT */
.qr-text{
    margin-top:10px;
    font-size:12px;
    color:#64748b;
}

/* FOOTER */
.footer{
    clear:both;
    margin-top:50px;
    border-top:1px solid #e5e7eb;
    text-align:center;
    padding-top:12px;
    color:#64748b;
    font-size:11px;
}

</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>AssetTrack</h1>
    <p>Sistem Manajemen Inventaris</p>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- LEFT -->
    <div class="left">

        <div class="product-title">
            {{ $product->name }}
        </div>

        <table>
            <tr>
                <td class="label">Kode Barang</td>
                <td>{{ $product->kode_barang }}</td>
            </tr>
            <tr>
                <td class="label">Kategori</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <td class="label">Lokasi</td>
                <td>{{ $product->location }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Stok</td>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi</td>
                <td>
                    <span class="badge">
                        {{ ucfirst($product->condition) }}
                    </span>
                </td>
            </tr>
        </table>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <img
            src="data:image/png;base64,{{ $qr }}"
            width="180"
            class="qr">

        <div class="qr-text">
            Scan QR Code untuk melihat<br>
            detail produk secara cepat
        </div>

    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    Dicetak pada {{ now()->format('d M Y H:i') }}<br>
    AssetTrack © {{ date('Y') }}
</div>

</body>
</html>