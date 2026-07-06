<x-app-layout>
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">
                📦 Riwayat Peminjaman
            </h2>

            <a href="{{ route('borrowings.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                + Ajukan Peminjaman
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET"
              action="{{ route('borrowings.index') }}"
              class="bg-white rounded-lg shadow p-4 mb-5">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Barang..."
                    class="border rounded-lg px-3 py-2">

                <select
                    name="status"
                    class="border rounded-lg px-3 py-2">

                    <option value="">Semua Status</option>

                    <option value="pending"
                        {{ request('status')=='pending'?'selected':'' }}>
                        Pending
                    </option>

                    <option value="approved"
                        {{ request('status')=='approved'?'selected':'' }}>
                        Approved
                    </option>

                    <option value="returned"
                        {{ request('status')=='returned'?'selected':'' }}>
                        Returned
                    </option>

                    <option value="rejected"
                        {{ request('status')=='rejected'?'selected':'' }}>
                        Rejected
                    </option>

                </select>

                <select
                    name="user"
                    class="border rounded-lg px-3 py-2">

                    <option value="">Semua User</option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            {{ request('user')==$user->id?'selected':'' }}>

                            {{ $user->name }}

                        </option>

                    @endforeach

                </select>

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="border rounded-lg px-3 py-2">

            </div>

            <div class="mt-4">

<div class="flex gap-3">

    <button
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

        Filter

    </button>

    <a href="{{ route('borrowings.index') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

        Reset

    </a>

</div>

            </div>

        </form>

        <div class="bg-white rounded-lg shadow overflow-x-auto">

            <table class="w-full">

                <thead class="bg-red-600 text-white">

                    <tr>

                        <th class="p-3">Peminjam</th>
                        <th class="p-3">Barang</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($borrowings as $borrowing)

                    @foreach($borrowing->details as $detail)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">
                            {{ $borrowing->user->name }}
                        </td>

                        <td class="p-3">
                            {{ $detail->product->name }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $detail->quantity }}
                        </td>

                        <td class="p-3 text-center">

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

                        </td>

                        <td class="p-3 text-center">

                            @if($borrowing->status=='pending')

                                <div class="flex justify-center gap-2">

                                <a href="{{ route('borrowings.show',$borrowing->id) }}"
                                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded inline-block">
                                        Detail
                                </a>

                                    <form
                                        action="{{ route('borrowings.approve',$borrowing->id) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">

                                            Approve

                                        </button>

                                    </form>

                                    <form
                                        action="{{ route('borrowings.reject',$borrowing->id) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                            Reject

                                        </button>

                                    </form>

                                </div>

                            @elseif($borrowing->status=='approved')

                                <form
                                    action="{{ route('borrowings.return',$borrowing->id) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">

                                        Return

                                    </button>

                                </form>

                            @else

                                <span class="text-gray-400">

                                    -

                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-8 text-gray-500">

                            Belum ada data peminjaman.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-5">
            {{ $borrowings->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>