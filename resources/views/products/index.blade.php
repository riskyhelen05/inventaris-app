<x-app-layout>

<x-slot name="header">
    Data Barang
</x-slot>

<div class="space-y-6">

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
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-6">

    <form method="GET">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            {{-- LEFT: INPUT FILTER --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 flex-1">

                {{-- Search --}}
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau kode barang..."
                        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                </div>

                {{-- Kategori --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Kategori
                    </label>

                    <select
                        name="category"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">

                        <option value="">Semua</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

{{-- Kondisi --}}
<div class="md:col-span-2">
    <label class="block text-xs font-medium text-gray-500 mb-1">
        Kondisi
    </label>

    <select
        name="condition"
        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">

        <option value="">Semua</option>
        <option value="baik" {{ request('condition')=='baik'?'selected':'' }}>Baik</option>
        <option value="rusak" {{ request('condition')=='rusak'?'selected':'' }}>Rusak</option>
        <option value="service" {{ request('condition')=='service'?'selected':'' }}>Service</option>
    </select>
</div>

{{-- STATUS STOK (BARU) --}}
<div class="md:col-span-3">
    <label class="block text-xs font-medium text-gray-500 mb-1">
        Status Stok
    </label>

    <select
        name="stock"
        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">

        <option value="">Semua</option>
        <option value="available" {{ request('stock')=='available'?'selected':'' }}>
            Stok Aman
        </option>
        <option value="low" {{ request('stock')=='low'?'selected':'' }}>
            Stok Menipis
        </option>
        <option value="out" {{ request('stock')=='out'?'selected':'' }}>
            Stok Habis
        </option>
    </select>
</div>

                {{-- Tombol Cari & Reset --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-transparent mb-1">
                        Action
                    </label>

                    <div class="flex gap-2 h-10">
                        <button
                            type="submit"
                            class="flex-1 h-full rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                            Cari
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="flex-1 h-full rounded-lg bg-gray-100 border border-gray-300 text-gray-700 text-sm font-medium flex items-center justify-center hover:bg-gray-200 transition">
                            Reset
                        </a>
                    </div>
                </div>

            </div>

            {{-- RIGHT: BUTTON TAMBAH --}}
            <div>
                <label class="block text-xs font-medium text-transparent mb-1">
                    Action
                </label>

@hasanyrole('admin|staff')
<a href="{{ route('products.create') }}" 
   class="flex items-center gap-2 bg-red-600 text-white px-5 h-10 rounded-xl font-semibold shadow hover:bg-red-700 transition">
    Tambah Barang
</a>
@endhasanyrole
            </div>

        </div>

    </form>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

    <table class="w-full text-sm">

        {{-- HEADER --}}
        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
            <tr>
                <th class="w-14 py-2 text-center">Foto</th>
                <th class="w-24 py-2 text-center">Kode</th>
                <th class="py-2 text-left">Nama Barang</th>
                <th class="w-32 py-2 text-center">Kategori</th>
                <th class="w-20 py-2 text-center">Stok</th>
                <th class="w-28 py-2 text-center">Lokasi</th>
                <th class="w-28 py-2 text-center">Kondisi</th>
                <th class="w-28 py-2 text-center">Aksi</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody class="divide-y divide-gray-100">

        @forelse($products as $product)

        <tr class="hover:bg-gray-50 transition">

            {{-- FOTO --}}
            <td class="text-center py-2">
                @if($product->image)
                    <img
                        src="{{ asset('storage/'.$product->image) }}"
                        class="w-9 h-9 mx-auto rounded-md object-cover" />
                @else
                    <div class="w-9 h-9 mx-auto rounded-md bg-gray-100 flex items-center justify-center text-xs">
                        <x-heroicon-o-cube class="w-5 h-5 text-gray-400"/>
                    </div>
                @endif
            </td>

            {{-- KODE --}}
            <td class="text-center py-2 text-xs text-gray-500">
                {{ $product->kode_barang }}
            </td>

            {{-- NAMA --}}
            <td class="py-2">
                <p class="font-medium text-gray-500 truncate">
                    {{ $product->name }}
                </p>
            </td>

            {{-- KATEGORI --}}
            <td class="text-center py-2 text-gray-500 text-xs truncate">
                {{ $product->category->name ?? '-' }}
            </td>

            {{-- STOK --}}
            <td class="text-center py-2">
                @if($product->stock==0)
                    <span class="text-xs text-red-500 font-medium">Habis</span>
                @elseif($product->stock<5)
                    <span class="text-xs text-yellow-600 font-medium">
                        {{ $product->stock }}
                    </span>
                @else
                    <span class="text-xs text-green-600 font-medium">
                        {{ $product->stock }}
                    </span>
                @endif
            </td>

            {{-- LOKASI --}}
            <td class="text-center py-2 text-gray-500 text-xs truncate">
                {{ $product->location }}
            </td>

            {{-- KONDISI --}}
            <td class="text-center py-2">
                @if($product->condition=='baik')
                    <span class="text-xs text-green-600 font-medium">Baik</span>
                @elseif($product->condition=='rusak')
                    <span class="text-xs text-red-600 font-medium">Rusak</span>
                @elseif($product->condition=='servis')
                    <span class="text-xs text-orange-500 font-medium">Servis</span>
                @else
                    <span class="text-xs text-gray-500">-</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td class="py-2">
                <div class="flex justify-center gap-1">

                    <a href="{{ route('products.edit',$product) }}"
                       class="w-7 h-7 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 transition"
                       title="Edit">
                        <x-heroicon-o-pencil-square class="w-4 h-4"/>
                    </a>

                    <a href="{{ route('products.show',$product) }}"
                       class="w-7 h-7 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 transition"
                       title="QR">
                        <x-heroicon-o-qr-code class="w-4 h-4"/>
                    </a>

                    <a href="{{ route('products.printQr',$product) }}"
                       class="w-7 h-7 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 transition"
                       title="Print">
                        <x-heroicon-o-printer class="w-4 h-4"/>
                    </a>

                    <form action="{{ route('products.destroy',$product) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')

                        <button
                            class="w-7 h-7 rounded-md text-gray-500 hover:bg-red-100 hover:text-red-600 transition"
                            title="Hapus">
                            <x-heroicon-o-trash class="w-4 h-4"/>
                        </button>
                    </form>

                </div>
            </td>

        </tr>

        @empty

        <tr>
            <td colspan="8" class="py-12 text-center">

                <div class="flex flex-col items-center gap-2">

                    <div class="text-4xl"><x-heroicon-o-cube class="w-5 h-5 text-gray-400"/></div>

                    <p class="text-gray-500 font-medium">
                        Belum ada data barang
                    </p>

                    <p class="text-gray-400 text-sm">
                        Tambahkan barang untuk mulai mengelola inventaris
                    </p>

                </div>

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