<x-app-layout>
    
<x-slot name="header">
    Kategori
</x-slot>

    <div class="space-y-6">

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-4 py-4">

            <div class="flex flex-col lg:flex-row lg:items-end gap-3">

                {{-- FORM --}}
                <form method="GET"
                    class="grid grid-cols-1 md:grid-cols-12 gap-2 flex-1">

                {{-- SEARCH --}}
                <div class="md:col-span-5">
                    <label class="text-xs text-gray-500 block mb-1">
                        Pencarian
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kategori..."
                        class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                </div>

                {{-- STATUS --}}
                <div class="md:col-span-3">
                    <label class="text-xs text-gray-500 block mb-1">
                        Status
                    </label>
                    <select name="product_filter"
                        class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-red-500">
                        <option value="">Semua</option>
                        <option value="used" @selected(request('product_filter')=='used')>
                            Memiliki Produk
                        </option>
                        <option value="empty" @selected(request('product_filter')=='empty')>
                            Belum Dipakai
                        </option>
                    </select>
                </div>

                {{-- SORT --}}
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 block mb-1">
                        Urutkan
                    </label>
                    <select name="sort"
                        class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-red-500">
                        <option value="">Semua</option>
                        <option value="latest" @selected(request('sort')=='latest')>Terbaru</option>
                        <option value="oldest" @selected(request('sort')=='oldest')>Terlama</option>
                        <option value="az" @selected(request('sort')=='az')>A-Z</option>
                        <option value="za" @selected(request('sort')=='za')>Z-A</option>
                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="md:col-span-2 flex gap-2 items-end">

                    <button
                        class="flex-1 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                        Filter
                    </button>

                    <a href="{{ route('categories.index') }}"
                        class="flex-1 h-9 bg-gray-100 border border-gray-300 text-gray-700 rounded-lg text-sm flex items-center justify-center hover:bg-gray-200 transition">
                        Reset
                    </a>

                </div>

            </form>

        {{-- TAMBAH --}}
        <a href="{{ route('categories.create') }}"
            class="h-9 px-4 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium flex items-center justify-center whitespace-nowrap transition">
            Tambah Kategori
        </a>

    </div>

</div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="w-12 py-2 text-center">No</th>
                        <th class="py-2 text-left">Nama Kategori</th>
                        <th class="w-24 py-2 text-center">Produk</th>
                        <th class="w-32 py-2 text-center">Dibuat</th>
                        <th class="w-24 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                @forelse($categories as $category)

                    <tr class="hover:bg-gray-50 transition">

                {{-- NO --}}
                <td class="text-center py-2 text-xs text-gray-500">
                    {{ $loop->iteration + ($categories->currentPage()-1) * $categories->perPage() }}
                </td>

                {{-- NAMA --}}
                <td class="py-2">
                    <p class="font-medium text-gray-700 truncate">
                        {{ $category->name }}
                    </p>
                </td>

                {{-- PRODUK --}}
                <td class="text-center py-2">
                    @if($category->products_count == 0)
                        <span class="text-xs text-gray-400">
                            0
                        </span>
                    @else
                        <span class="text-xs font-semibold text-green-600">
                            {{ $category->products_count }}
                        </span>
                    @endif
                </td>

                {{-- TANGGAL --}}
                <td class="text-center py-2 text-xs text-gray-500">
                    {{ $category->created_at?->format('d M Y') ?? '-' }}
                </td>

                {{-- AKSI --}}
                <td class="py-2">
                    <div class="flex justify-center gap-1">

                        {{-- EDIT --}}
                        <a href="{{ route('categories.edit',$category) }}"
                            class="w-7 h-7 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 transition"
                            title="Edit">
                            <x-heroicon-o-pencil-square class="w-4 h-4"/>
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('categories.destroy',$category) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
            <td colspan="5" class="py-12 text-center">

                <div class="flex flex-col items-center gap-2">

                    <div class="text-gray-300">
                        <x-heroicon-o-folder class="w-10 h-10"/>
                    </div>

                    <p class="text-gray-500 font-medium">
                        Belum ada kategori
                    </p>

                    <p class="text-gray-400 text-sm">
                        Tambahkan kategori untuk mulai mengelola data
                    </p>

                </div>

            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>

        {{-- PAGINATION --}}
        <div class="pt-2">
            {{ $categories->links() }}
        </div>

    </div>
</x-app-layout>