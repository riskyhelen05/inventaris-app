<x-app-layout>
    <x-slot name="header">
        <h2>Daftar Produk</h2>
    </x-slot>

    <div class="p-6">

        <!-- SEARCH -->
        <form method="GET" action="{{ route('products.index') }}">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>

        <br>

        <!-- TAMBAH -->
        <a href="{{ route('products.create') }}">Tambah Produk</a>

        <br><br>

        <!-- ALERT -->
        @if(session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red">{{ session('error') }}</p>
        @endif

        <!-- TABLE -->
        <table border="1" cellpadding="10">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>

            @foreach($products as $product)
            <tr>
                <td>{{ $product->kode_barang }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->location }}</td>
                <td>{{ $product->condition }}</td>

                <td>

                    <!-- EDIT -->
                    <a href="{{ route('products.edit', $product->id) }}">Edit</a>

                    <!-- DELETE -->
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>

                    <br><br>

                    <!-- PINJAM -->
                    <form action="{{ route('borrow.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" placeholder="Jumlah" min="1" required style="width: 60px;">
                        <button type="submit">Pinjam</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </table>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
</x-app-layout>