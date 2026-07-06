<x-app-layout>

    <div class="p-6">

<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold text-gray-800">
            📄 Laporan Peminjaman
        </h2>

        <p class="text-gray-500 text-sm">
            Daftar seluruh transaksi peminjaman barang.
        </p>

    </div>

<div class="flex gap-2">

    <a href="{{ route('reports.pdf', request()->query()) }}"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">

        Export PDF

    </a>

    <a href="{{ route('reports.excel', request()->query()) }}"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">

        Export Excel

    </a>

</div>

</div>

{{-- FILTER --}}
<form
    method="GET"
    action="{{ route('reports.index') }}"
    class="bg-white rounded-xl shadow p-4 mb-6">

    <div class="grid md:grid-cols-4 gap-4">

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
                {{ request('status')=='pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="approved"
                {{ request('status')=='approved' ? 'selected' : '' }}>
                Approved
            </option>

            <option value="returned"
                {{ request('status')=='returned' ? 'selected' : '' }}>
                Returned
            </option>

            <option value="rejected"
                {{ request('status')=='rejected' ? 'selected' : '' }}>
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
                    {{ request('user')==$user->id ? 'selected' : '' }}>

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

    <div class="mt-4 flex gap-2">

        <button
            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

            Filter

        </button>

        <a href="{{ route('reports.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

            Reset

        </a>

    </div>

</form>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-xl shadow p-5">

        <p class="text-gray-500 text-sm">
            Total Borrowing
        </p>

        <h2 class="text-3xl font-bold text-red-600 mt-2">

            {{ $totalBorrowing }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-5">

        <p class="text-gray-500 text-sm">
            Approved
        </p>

        <h2 class="text-3xl font-bold text-blue-600 mt-2">

            {{ $totalApproved }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-5">

        <p class="text-gray-500 text-sm">
            Returned
        </p>

        <h2 class="text-3xl font-bold text-green-600 mt-2">

            {{ $totalReturned }}

        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-5">

        <p class="text-gray-500 text-sm">
            Rejected
        </p>

        <h2 class="text-3xl font-bold text-red-500 mt-2">

            {{ $totalRejected }}

        </h2>

    </div>

</div> 

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full">

                <thead class="bg-red-600 text-white">

                    <tr>

                        <th class="p-3 text-left">
                            Peminjam
                        </th>

                        <th class="p-3 text-left">
                            Barang
                        </th>

                        <th class="p-3 text-center">
                            Qty
                        </th>

                        <th class="p-3 text-center">
                            Status
                        </th>

                        <th class="p-3 text-center">
                            Tanggal
                        </th>

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

                                {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}

                            </td>

                        </tr>

                    @endforeach

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-10 text-gray-500">

                            Belum ada data laporan.

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