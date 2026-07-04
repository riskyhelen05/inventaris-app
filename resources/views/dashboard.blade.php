<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div class="p-6">

        <div>Total Produk: {{ $totalProducts }}</div>
        <div>Total Stok: {{ $totalStock }}</div>
        <div>Barang Dipinjam: {{ $totalBorrowed }}</div>
        <div>Total User: {{ $totalUsers }}</div>

    </div>
</x-app-layout>