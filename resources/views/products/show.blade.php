<x-app-layout>

<x-slot name="header">
    Detail Produk
</x-slot>

<div class="max-w-5xl mx-auto space-y-4">

{{-- CARD UTAMA --}}
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-600 to-red-500 px-4 py-3 text-white">

        <div class="space-y-1">

            <h2 class="text-2xl font-bold text-white leading-tight">
                {{ $product->name }}
            </h2>

            <p class="text-red-100 text-xs">
                Informasi lengkap dan status produk
            </p>
        </div>

    </div>

        {{-- CONTENT --}}
        <div class="p-5">

            <div class="grid md:grid-cols-3 gap-5 items-start">

                {{-- GAMBAR --}}
                <div>
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">

                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                Tidak ada gambar
                            </div>
                        @endif

                    </div>
                </div>

                {{-- INFO --}}
                <div class="md:col-span-2 space-y-4 text-sm">

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-gray-400 text-xs">Kode</p>
                            <p class="font-semibold">{{ $product->kode_barang }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Kategori</p>
                            <p class="font-semibold">{{ $product->category->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Lokasi</p>
                            <p class="font-semibold">{{ $product->location }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Stok</p>
                            <p class="font-semibold">{{ $product->stock }}</p>
                        </div>

                    </div>

                    {{-- KONDISI --}}
                    @php
                        $colors = [
                            'baik' => 'bg-green-100 text-green-700',
                            'rusak' => 'bg-red-100 text-red-700',
                            'servis' => 'bg-yellow-100 text-yellow-700',
                        ];
                    @endphp

                    <div class="flex justify-between items-center pt-2 border-t">
                        <span class="text-gray-400 text-xs">Kondisi</span>

                        <span class="px-2 py-0.5 rounded-full text-xs {{ $colors[$product->condition] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($product->condition) }}
                        </span>
                    </div>

                    {{-- QR --}}
                    <div class="flex flex-col items-center pt-3 border-t">

                        {!! QrCode::size(90)->generate(route('products.show',$product)) !!}

                    <p class="text-xs text-gray-500 mt-2 text-center">
                        Scan QR untuk membuka detail produk
                    </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- BUTTON BAWAH --}}
    <div class="flex justify-end">
        <a href="{{ route('products.index') }}"
           class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm">
            ← Kembali
        </a>
    </div>

</div>

</x-app-layout>