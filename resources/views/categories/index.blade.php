<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Manajemen Kategori
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Search + Button --}}
        <div class="bg-white rounded-xl shadow p-5 mb-6">

            <div class="flex flex-col md:flex-row justify-between gap-4">

                <form method="GET" class="flex flex-wrap items-center gap-3">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama kategori..."
        class="border rounded-lg px-4 py-2 w-64">

    <select
        name="product_filter"
        class="border rounded-lg px-3 py-2">

        <option value="">Semua</option>

        <option value="used"
            @selected(request('product_filter')=='used')>
            Memiliki Produk
        </option>

        <option value="empty"
            @selected(request('product_filter')=='empty')>
            Belum Dipakai
        </option>

    </select>

    <select
        name="sort"
        class="border rounded-lg px-3 py-2">

        <option value="latest"
            @selected(request('sort')=='latest')>
            Terbaru
        </option>

        <option value="oldest"
            @selected(request('sort')=='oldest')>
            Terlama
        </option>

        <option value="az"
            @selected(request('sort')=='az')>
            A-Z
        </option>

        <option value="za"
            @selected(request('sort')=='za')>
            Z-A
        </option>

    </select>

    <button
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
        Filter
    </button>

    <a href="{{ route('categories.index') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
        Reset
    </a>

</form>

                <a href="{{ route('categories.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-center">
                    + Tambah Kategori
                </a>

            </div>

        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="w-full">

                <thead class="bg-red-600 text-white">

                    <tr>

                        <th class="p-4 text-left">No</th>

                        <th class="p-4 text-left">
                            Nama Kategori
                        </th>

                        <th class="p-4 text-center">
                            Jumlah Produk
                        </th>

                        <th class="p-4 text-center">
                            Dibuat
                        </th>

                        <th class="p-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)

                    <tr class="border-b hover:bg-red-50 transition">

                        <td class="p-4">
                            {{ $loop->iteration + ($categories->currentPage()-1) * $categories->perPage() }}
                        </td>

                        <td class="p-4 font-semibold">
                            {{ $category->name }}
                        </td>

                        <td class="p-4 text-center">

    @if($category->products_count == 0)

        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
            Belum digunakan
        </span>

    @else

        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
            {{ $category->products_count }} Produk
        </span>

    @endif

</td>

                        <td class="p-4 text-center text-gray-500">
                            {{ $category->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('categories.edit',$category) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form
class="delete-form"
action="{{ route('categories.destroy',$category) }}"
method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
type="button"
class="delete-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
Hapus
</button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

<td colspan="5" class="text-center py-12">

<div class="flex flex-col items-center">

<div class="text-6xl mb-3">
📂
</div>

<h3 class="text-lg font-semibold text-gray-600">
Belum ada kategori
</h3>

<p class="text-gray-400">
Silakan tambahkan kategori baru.
</p>

<a href="{{ route('categories.create') }}"
class="mt-4 bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

+ Tambah Kategori

</a>

</div>

</td>

</tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>