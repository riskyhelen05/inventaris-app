<x-app-layout>

<x-slot name="header">
    Detail Peminjaman
</x-slot>

<div class="space-y-6">

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">

        <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-red-600"/>
            Detail Peminjaman
        </h2>
        <p class="text-sm text-gray-500">
            Informasi lengkap data peminjaman barang
        </p>
    </div>

        {{-- INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-xs text-gray-500">Peminjam</p>
                <h3 class="font-semibold text-lg text-gray-800">
                    {{ $borrowing->user->name }}
                </h3>
            </div>

            <div>
                <p class="text-xs text-gray-500">Tanggal Pinjam</p>
                <h3 class="font-semibold text-gray-800">
                    {{ $borrowing->borrow_date }}
                </h3>
            </div>

            <div>
                <p class="text-xs text-gray-500">Tanggal Kembali</p>
                <h3 class="font-semibold text-gray-800">
                    {{ $borrowing->return_date ?? '-' }}
                </h3>
            </div>

            <div>
                <p class="text-xs text-gray-500 mb-1">Status</p>

                @switch($borrowing->status)
                    @case('pending')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                            Pending
                        </span>
                    @break

                    @case('approved')
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            Approved
                        </span>
                    @break

                    @case('returned')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                            Returned
                        </span>
                    @break

                    @case('rejected')
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                            Rejected
                        </span>
                    @break
                @endswitch

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border border-gray-200">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Barang</th>
                        <th class="px-4 py-3 text-center w-24">Qty</th>
                        <th class="px-4 py-3 text-center w-40">Stok Saat Ini</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($borrowing->details as $detail)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3 text-gray-800">
                            {{ $detail->product->name }}
                        </td>

                        <td class="px-4 py-3 text-center font-medium">
                            {{ $detail->quantity }}
                        </td>

                        <td class="px-4 py-3 text-center text-gray-600">
                            {{ $detail->product->stock }}
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="3" class="py-10 text-center text-gray-400">
                            Tidak ada data barang
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-end pt-4">

            <a href="{{ route('borrowings.index') }}"
               class="flex items-center gap-2 px-4 h-10 rounded-lg bg-gray-100 border border-gray-300 text-gray-700 text-sm hover:bg-gray-200 transition">

                <x-heroicon-o-arrow-left class="w-4 h-4"/>
                Kembali

            </a>

        </div>

    </div>

</div>

</x-app-layout>