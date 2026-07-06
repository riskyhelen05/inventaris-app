<x-app-layout>

    <div class="p-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">
                📦 Detail Peminjaman
            </h2>

            <a href="{{ route('borrowings.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">

                ← Kembali

            </a>

        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">

            <div class="grid grid-cols-2 gap-6">

                <div>

                    <p class="text-gray-500">
                        Peminjam
                    </p>

                    <h3 class="font-semibold text-lg">
                        {{ $borrowing->user->name }}
                    </h3>

                </div>

                <div>

                    <p class="text-gray-500">
                        Tanggal Pinjam
                    </p>

                    <h3 class="font-semibold">
                        {{ $borrowing->borrow_date }}
                    </h3>

                </div>

                <div>

                    <p class="text-gray-500">
                        Tanggal Kembali
                    </p>

                    <h3 class="font-semibold">

                        {{ $borrowing->return_date ?? '-' }}

                    </h3>

                </div>

                <div>

                    <p class="text-gray-500">
                        Status
                    </p>

                    @switch($borrowing->status)

                        @case('pending')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                Pending
                            </span>

                        @break

                        @case('approved')

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                Approved
                            </span>

                        @break

                        @case('returned')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Returned
                            </span>

                        @break

                        @case('rejected')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Rejected
                            </span>

                        @break

                    @endswitch

                </div>

            </div>

        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">

            <table class="w-full">

                <thead class="bg-red-600 text-white">

                    <tr>

                        <th class="p-3 text-left">
                            Barang
                        </th>

                        <th class="p-3 text-center">
                            Qty
                        </th>

                        <th class="p-3 text-center">
                            Stok Saat Ini
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($borrowing->details as $detail)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">

                                {{ $detail->product->name }}

                            </td>

                            <td class="p-3 text-center">

                                {{ $detail->quantity }}

                            </td>

                            <td class="p-3 text-center">

                                {{ $detail->product->stock }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>