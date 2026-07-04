<x-app-layout>
    <x-slot name="header">
        <h2>Edit Produk</h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ $product->kode_barang }}" required>
            </div>

            <div>
                <label>Nama</label>
                <input type="text" name="name" value="{{ $product->name }}" required>
            </div>

            <div>
                <label>Kategori</label>
                <select name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required>
            </div>

            <div>
                <label>Lokasi</label>
                <input type="text" name="location" value="{{ $product->location }}" required>
            </div>

            <div>
                <label>Kondisi</label>
                <input type="text" name="condition" value="{{ $product->condition }}" required>
            </div>

            <div>
                <label>Gambar</label>
                <input type="file" name="image">
            </div>

            <button type="submit">Update</button>

        </form>

    </div>
</x-app-layout>