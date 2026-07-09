<x-app-layout>

<x-slot name="header">
    Laporan
</x-slot>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-6">

    <form method="GET" action="{{ route('reports.index') }}">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            {{-- LEFT --}}
            <div class="grid grid-cols-1 md:grid-cols-10 gap-3 flex-1">

                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 mb-1 block">Pencarian</label>
                    <input type="text" name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari barang..."
                        class="w-full h-10 rounded-lg border-gray-300 text-sm">
                </div>

                {{-- Status (diperkecil) --}}
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 mb-1 block">Status</label>
                    <select name="status"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                        <option value="returned" {{ request('status')=='returned'?'selected':'' }}>Returned</option>
                        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                </div>

                {{-- User --}}
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 mb-1 block">User</label>
                    <select name="user"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm">
                        <option value="">Semua</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ request('user')==$user->id?'selected':'' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 mb-1 block">Tanggal</label>
                    <input type="date" name="date"
                        value="{{ request('date') }}"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm">
                </div>

                {{-- Buttons (dibesarin biar aman) --}}
                <div class="md:col-span-2 flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 h-10 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                        Cari
                    </button>

                    <a href="{{ route('reports.index') }}"
                        class="h-10 w-10 flex items-center justify-center bg-gray-100 border text-gray-600 rounded-lg hover:bg-gray-200">
                        <x-heroicon-o-arrow-path class="w-4 h-4"/>
                    </a>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="flex gap-2 shrink-0">

                <a href="{{ route('reports.pdf', request()->query()) }}"
                   class="flex items-center gap-2 bg-red-600 text-white px-4 h-10 rounded-xl text-sm hover:bg-red-700">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4"/>
                    PDF
                </a>

                <a href="{{ route('reports.excel', request()->query()) }}"
                   class="flex items-center gap-2 bg-green-600 text-white px-4 h-10 rounded-xl text-sm hover:bg-green-700">
                    <x-heroicon-o-table-cells class="w-4 h-4"/>
                    Excel
                </a>

            </div>

        </div>

    </form>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

    <table class="w-full text-sm">

        {{-- HEADER --}}
        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
            <tr>
                <th class="px-4 py-2 text-left">Peminjam</th>
                <th class="py-2 text-left">Barang</th>
                <th class="w-20 py-2 text-center">Qty</th>
                <th class="w-28 py-2 text-center">Status</th>
                <th class="w-32 py-2 text-center">Tanggal</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody class="divide-y divide-gray-100">

        @forelse($borrowings as $borrowing)

            @foreach($borrowing->details as $detail)

            <tr class="hover:bg-gray-50 transition">

                {{-- USER --}}
                <td class="px-4 py-2">
                    <p class="font-medium text-gray-700">
                        {{ $borrowing->user->name }}
                    </p>
                </td>

                {{-- BARANG --}}
                <td class="py-2 text-gray-500">
                    {{ $detail->product->name }}
                </td>

                {{-- QTY --}}
                <td class="text-center py-2 text-gray-600">
                    {{ $detail->quantity }}
                </td>

                {{-- STATUS --}}
                <td class="text-center py-2">
                    @switch($borrowing->status)

                        @case('pending')
                            <span class="text-xs font-medium text-yellow-600">
                                Pending
                            </span>
                        @break

                        @case('approved')
                            <span class="text-xs font-medium text-blue-600">
                                Approved
                            </span>
                        @break

                        @case('returned')
                            <span class="text-xs font-medium text-green-600">
                                Returned
                            </span>
                        @break

                        @case('rejected')
                            <span class="text-xs font-medium text-red-600">
                                Rejected
                            </span>
                        @break

                    @endswitch
                </td>

                {{-- TANGGAL --}}
                <td class="text-center py-2 text-gray-500 text-xs">
                    {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                </td>

            </tr>

            @endforeach

        @empty

        <tr>
            <td colspan="5" class="py-12 text-center">

                <div class="flex flex-col items-center gap-2">

                    <div class="text-gray-300">
                        <x-heroicon-o-clipboard-document-list class="w-10 h-10"/>
                    </div>

                    <p class="text-gray-500 font-medium">
                        Belum ada data laporan
                    </p>

                    <p class="text-gray-400 text-sm">
                        Data peminjaman akan muncul di sini
                    </p>

                </div>

            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>

        <div class="mt-5">

            {{ $borrowings->links() }}

        </div>

    </div>

</x-app-layout>