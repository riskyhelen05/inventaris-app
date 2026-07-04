<x-app-layout>
    <x-slot name="header">
        <h2>Tambah Produk</h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" required>
            </div>

            <div>
                <label>Nama</label>
                <input type="text" name="name" required>
            </div>

            <div>
                <label>Kategori</label>
                <select name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Stok</label>
                <input type="number" name="stock" required>
            </div>

            <div>
                <label>Lokasi</label>
                <input type="text" name="location" required>
            </div>

            <div>
                <label>Kondisi</label>
                <input type="text" name="condition" required>
            </div>

            <div>
                <label>Gambar</label>
                <input type="file" name="image">
            </div>

            <button type="submit">Simpan</button>

        </form>

    </div>
</x-app-layout>