<x-app-layout>
    <x-slot name="header">
        <h2>Daftar Produk</h2>
    </x-slot>

    <div class="p-6">

        <form method="GET" action="{{ route('products.index') }}">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>

        <a href="{{ route('products.create') }}">Tambah Produk</a>

        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <table border="1">
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
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->location }}</td>
                <td>{{ $product->condition }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}">Edit</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                    <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
</x-app-layout>