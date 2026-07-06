<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Daftar Produk
                </h2>
                <p class="text-gray-500 text-sm">
                    Kelola seluruh data inventaris barang
                </p>
            </div>

            <a href="{{ route('products.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow">
                + Tambah Barang
            </a>
        </div>
    </x-slot>


<div class="p-6">

    {{-- CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500 text-sm">Total Barang</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">
                {{ $totalBarang }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500 text-sm">Total Stok</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $stokTersedia }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500 text-sm">Stok Habis</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">
                {{ $stokHabis }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500 text-sm">Kategori</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalKategori }}
            </h2>
        </div>

    </div>



    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif



    {{-- FILTER --}}
    <div class="bg-white shadow rounded-xl p-5 mb-5">

        <form method="GET">

            <div class="grid md:grid-cols-4 gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / kode barang..."
                    class="border rounded-lg p-2">

                <select
                    name="category"
                    class="border rounded-lg p-2">

                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ request('category')==$category->id?'selected':'' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>


                <select
                    name="condition"
                    class="border rounded-lg p-2">

                    <option value="">Semua Kondisi</option>

                    <option value="baik"
                        {{ request('condition')=='baik'?'selected':'' }}>
                        Baik
                    </option>

                    <option value="rusak"
                        {{ request('condition')=='rusak'?'selected':'' }}>
                        Rusak
                    </option>

                </select>


                <div class="flex gap-2">

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-5 rounded-lg">

                        Search

                    </button>

                    <a href="{{ route('products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 px-5 rounded-lg flex items-center">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>



    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-red-600 text-white">

            <tr>

                <th class="p-3">Foto</th>

                <th>Kode</th>

                <th>Nama</th>

                <th>Kategori</th>

                <th>Stok</th>

                <th>Lokasi</th>

                <th>Kondisi</th>

                <th class="text-center">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($products as $product)

            <tr class="border-b hover:bg-red-50 transition">

                <td class="p-3">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/'.$product->image) }}"
                            class="w-14 h-14 rounded-lg object-cover">

                    @else

                        <div class="w-14 h-14 rounded-lg bg-gray-200 flex items-center justify-center">

                            📦

                        </div>

                    @endif

                </td>

                <td>{{ $product->kode_barang }}</td>

                <td class="font-semibold">
                    {{ $product->name }}
                </td>

                <td>
                    {{ $product->category->name ?? '-' }}
                </td>

                <td>

                    @if($product->stock==0)

                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">

                            Habis

                        </span>

                    @elseif($product->stock<5)

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                            {{ $product->stock }}

                        </span>

                    @else

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                            {{ $product->stock }}

                        </span>

                    @endif

                </td>

                <td>
                    {{ $product->location }}
                </td>

                <td>

                    @if($product->condition=='baik')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                            Baik

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                            Rusak

                        </span>

                    @endif

                </td>

                <td>

                    <div class="flex justify-center gap-2">

                        <a
                            href="{{ route('products.edit',$product->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">

                            Edit

                        </a>

                        <form
                            action="{{ route('products.destroy',$product->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center py-10 text-gray-400">

                    Tidak ada data barang.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    <div class="mt-6">

        {{ $products->links() }}

    </div>

</div>

</x-app-layout>