<x-app-layout>
    <x-slot name="header">
        <h2>History Peminjaman</h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red">{{ session('error') }}</p>
        @endif

        <table border="1" cellpadding="10">
            <tr>
                <th>User</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @foreach($borrowings as $b)
            <tr>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->product->name }}</td>
                <td>{{ $b->quantity }}</td>
                <td>{{ $b->borrow_date }}</td>
                <td>{{ $b->status }}</td>

                <td>
                    @if($b->status == 'borrowed')
                        <form action="{{ route('borrow.return', $b->id) }}" method="POST">
                            @csrf
                            <button type="submit">Kembalikan</button>
                        </form>
                    @else
                        ✔ Selesai
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        {{ $borrowings->links() }}

    </div>
</x-app-layout>