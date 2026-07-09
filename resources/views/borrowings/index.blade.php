<x-app-layout>

<x-slot name="header">
    Riwayat Peminjaman
</x-slot>

    <div class="space-y-6">

        {{-- FILTER --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-6">

            <form method="GET" action="{{ route('borrowings.index') }}">

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

                    {{-- Status --}}
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

                    {{-- Buttons --}}
                    <div class="md:col-span-2 flex items-end gap-2">

                        <button type="submit"
                            class="flex-1 h-10 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                            Cari
                        </button>

                        <a href="{{ route('borrowings.index') }}"
                            class="h-10 w-10 flex items-center justify-center bg-gray-100 border text-gray-600 rounded-lg hover:bg-gray-200">
                            <x-heroicon-o-arrow-path class="w-4 h-4"/>
                        </a>

                    </div>

                </div>

                {{-- RIGHT --}}
@role('user')
<div class="flex gap-2 shrink-0">
    <a href="{{ route('borrowings.create') }}"
        class="flex items-center gap-2 bg-red-600 text-white px-4 h-10 rounded-xl text-sm hover:bg-red-700 whitespace-nowrap">
        Ajukan Peminjaman
    </a>
</div>
@endrole

                </div>

            </form>

        </div>

        {{-- TABLE --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <table class="w-full text-sm">

            {{-- HEADER --}}
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Peminjam</th>
                    <th class="px-4 py-3 text-left">Barang</th>
                    <th class="px-4 py-3 text-center w-24">Qty</th>
                    <th class="px-4 py-3 text-center w-32">Tanggal Pinjam</th>
                    <th class="px-4 py-3 text-center w-32">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-center w-28">Status</th>
                    <th class="px-4 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-gray-100">

            @forelse($borrowings as $borrowing)

            <tr class="hover:bg-gray-50 transition">

                {{-- PEMINJAM --}}
                <td class="px-4 py-3 align-top">
                    <p class="font-semibold text-gray-800">
                        {{ $borrowing->user->name }}
                    </p>
                </td>

                {{-- BARANG --}}
                <td class="px-4 py-3">
                    <div class="space-y-1">
                        @foreach($borrowing->details as $detail)
                            <p class="text-sm text-gray-700 truncate">
                                {{ $detail->product->name }}
                            </p>
                        @endforeach
                    </div>
                </td>

                {{-- QTY --}}
                <td class="px-4 py-3 text-center align-top">
                    <div class="space-y-1">
                        @foreach($borrowing->details as $detail)
                            <p class="text-xs font-medium text-gray-800">
                                {{ $detail->quantity }}
                        @endforeach
                    </div>
                </td>

                {{-- TGL PINJAM --}}
                <td class="px-4 py-3 text-center text-xs text-gray-700">
                    {{ $borrowing->borrow_date }}
                </td>

                {{-- TGL KEMBALI --}}
                <td class="px-4 py-3 text-center text-xs text-gray-700">
                    {{ $borrowing->return_date ?? '-' }}
                </td>

                {{-- STATUS --}}
                <td class="px-4 py-3 text-center">
                    @switch($borrowing->status)

                        @case('pending')
                            <span class="text-xs text-yellow-600 font-medium">Pending</span>
                        @break

                        @case('approved')
                            <span class="text-xs text-blue-600 font-medium">Approved</span>
                        @break

                        @case('returned')
                            <span class="text-xs text-green-600 font-medium">Returned</span>
                        @break

                        @case('rejected')
                            <span class="text-xs text-red-600 font-medium">Rejected</span>
                        @break

                    @endswitch
                </td>

                {{-- AKSI --}}
                <td class="px-4 py-3">
                    <div class="flex justify-center gap-2">

                        {{-- VIEW --}}
                        <a href="{{ route('borrowings.show',$borrowing->id) }}"
                            title="Lihat Detail"
                            class="w-8 h-8 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 transition">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>

                    @if($borrowing->status=='pending')

                        {{-- APPROVE --}}
                        <form action="{{ route('borrowings.approve',$borrowing->id) }}" method="POST"
                            onsubmit="return confirm('Setujui peminjaman ini?')">
                            @csrf
                                <button type="submit"
                                    title="Setujui"
                                    class="w-8 h-8 flex items-center justify-center rounded-md text-green-600 hover:bg-green-100 transition">
                                <x-heroicon-o-check class="w-4 h-4"/>
                                </button>
                        </form>

                        {{-- REJECT --}}
                        <form action="{{ route('borrowings.reject',$borrowing->id) }}" method="POST"
                            onsubmit="return confirm('Tolak peminjaman ini?')">
                            @csrf
                                <button type="submit"
                                    title="Tolak"
                                    class="w-8 h-8 flex items-center justify-center rounded-md text-red-600 hover:bg-red-100 transition">
                                    <x-heroicon-o-x-mark class="w-4 h-4"/>
                                </button>
                        </form>

                    @elseif($borrowing->status=='approved')

                        {{-- RETURN --}}
                        <form action="{{ route('borrowings.return',$borrowing->id) }}" method="POST"
                            onsubmit="return confirm('Tandai sebagai sudah dikembalikan?')">
                            @csrf
                                <button type="submit"
                                    title="Tandai Dikembalikan"
                                    class="w-8 h-8 flex items-center justify-center rounded-md text-blue-600 hover:bg-blue-100 transition">
                                    <x-heroicon-o-arrow-path class="w-4 h-4"/>
                                </button>
                        </form>

                    @endif

                </div>
            </td>

            </tr>

            @empty

            <tr>
                <td colspan="7" class="py-12 text-center">

                    <div class="flex flex-col items-center gap-2">

                        <div class="text-gray-300">
                            <x-heroicon-o-clipboard-document-list class="w-10 h-10"/>
                        </div>

                        <p class="text-gray-500 font-medium">
                            Belum ada data peminjaman
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

        {{-- PAGINATION --}}
        <div class="pt-2">
            {{ $borrowings->withQueryString()->links() }}
        </div>

    </div>

</x-app-layout>