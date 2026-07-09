<x-app-layout>

<x-slot name="header">
    Ajukan Peminjaman
</x-slot>

    <div class="space-y-6">

            {{-- FORM CARD --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

                    <form action="{{ route('borrowings.store') }}" method="POST">

                    <div class="mb-6">

                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <x-heroicon-o-cube class="w-6 h-6"/>
                            Pinjam Barang
                        </h2>

                        <p class="text-sm text-gray-500">
                            Pilih barang yang ingin dipinjam, lalu tentukan jumlahnya
                        </p>
    
                    </div>

            {{-- INFO --}}
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-xl p-4">
                    Kamu bisa menambahkan lebih dari satu barang dalam satu pengajuan.
                </div>

            @csrf

            {{-- ITEMS --}}
            <div id="items" class="space-y-4">

                {{-- ITEM --}}
                <div class="border rounded-xl p-4 bg-gray-50 item">

                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-semibold text-gray-700">
                            Barang #1
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">

                        {{-- PRODUK --}}
                        <div class="md:col-span-6">
                            <label class="text-xs text-gray-500 mb-1 block">
                                Pilih Produk
                            </label>

                            <select
                                name="products[0][product_id]"
                                class="w-full h-10 rounded-lg border-gray-300 text-sm"
                                onchange="updateMaxQty(this)"
                                required>

                                <option value="">-- Pilih Barang --</option>

                                @foreach ($products as $product)
                                    <option
                                        value="{{ $product->id }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        {{ $product->name }} (stok: {{ $product->stock }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- QTY --}}
                        <div class="md:col-span-3">
                            <label class="text-xs text-gray-500 mb-1 block">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="products[0][qty]"
                                class="w-full h-10 rounded-lg border-gray-300 text-sm qty-input"
                                placeholder="Masukkan jumlah"
                                min="1"
                                required>
                        </div>

                        {{-- REMOVE --}}
                        <div class="md:col-span-3 flex items-end">
                            <button
                                type="button"
                                onclick="removeItem(this)"
                                class="w-full h-10 rounded-lg bg-red-100 text-red-600 text-sm hover:bg-red-200 transition">
                                Hapus
                            </button>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex flex-col md:flex-row md:justify-between gap-3 mt-6">

                {{-- LEFT --}}
                    <button
                        type="button"
                        onclick="addItem()"
                        class="h-10 px-4 rounded-lg bg-gray-100 border text-gray-700 text-sm hover:bg-gray-200 transition">
                        + Tambah Barang
                    </button>

                {{-- RIGHT --}}
                    <div class="flex gap-2">

                        {{-- BATAL --}}
                            <a href="{{ route('borrowings.index') }}"
                                onclick="return confirm('Yakin mau batal? Data belum disimpan.')"
                                class="h-10 px-4 flex items-center rounded-lg bg-gray-100 border border-gray-300 text-gray-700 text-sm hover:bg-gray-200 transition">
                                Batal
                            </a>

                        {{-- SUBMIT --}}
                            <button
                                type="submit"
                                class="h-10 px-6 rounded-xl bg-green-600 text-white font-semibold hover:bg-green-700 transition shadow">
                                Ajukan Peminjaman
                            </button>

                    </div>

                </div>

        </form>

    </div>

</div>

<script>
let index = 1;

function addItem(){
    let container = document.getElementById('items');

    let html = `
    <div class="border rounded-xl p-4 bg-gray-50 item">

        <div class="flex justify-between items-center mb-3">
            <p class="text-sm font-semibold text-gray-700">
                Barang #${index + 1}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">

            <div class="md:col-span-6">
                <select name="products[${index}][product_id]"
                    class="w-full h-10 rounded-lg border-gray-300 text-sm"
                    onchange="updateMaxQty(this)"
                    required>

                    <option value="">-- Pilih Barang --</option>

                    @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        data-stock="{{ $product->stock }}"
                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                        {{ $product->name }} (stok: {{ $product->stock }})
                    </option>
                    @endforeach

                </select>
            </div>

            <div class="md:col-span-3">
                <input type="number"
                    name="products[${index}][qty]"
                    class="w-full h-10 rounded-lg border-gray-300 text-sm qty-input"
                    placeholder="Jumlah"
                    min="1"
                    required>
            </div>

            <div class="md:col-span-3 flex items-end">
                <button type="button"
                    onclick="removeItem(this)"
                    class="w-full h-10 rounded-lg bg-red-100 text-red-600 text-sm hover:bg-red-200">
                    Hapus
                </button>
            </div>

        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    index++;
}

function removeItem(button){
    let items = document.querySelectorAll('.item');

    if(items.length === 1){
        alert('Minimal harus ada satu barang.');
        return;
    }

    button.closest('.item').remove();
}

function updateMaxQty(select){
    let stock = select.options[select.selectedIndex].dataset.stock;
    let qtyInput = select.closest('.item').querySelector('.qty-input');

    if(stock){
        qtyInput.max = stock;
        qtyInput.placeholder = "Max: " + stock;

        if(qtyInput.value > stock){
            qtyInput.value = stock;
        }
    }
}
</script>

</x-app-layout>