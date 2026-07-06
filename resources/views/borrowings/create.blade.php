<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            📦 Pinjam Barang
        </h2>

        <form action="{{ route('borrowings.store') }}" method="POST">
            @csrf

            <div id="items">

                <div class="flex gap-4 mb-3 item">

                    {{-- Produk --}}
                    <select
                        name="products[0][product_id]"
                        class="w-1/2 border rounded p-2 product-select"
                        onchange="updateMaxQty(this)"
                        required>

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        @foreach ($products as $product)

                            <option
                                value="{{ $product->id }}"
                                data-stock="{{ $product->stock }}"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>

                                {{ $product->name }}
                                (stok: {{ $product->stock }})

                            </option>

                        @endforeach

                    </select>

                    {{-- Qty --}}
                    <input
                        type="number"
                        name="products[0][qty]"
                        class="w-1/4 border rounded p-2 qty-input"
                        placeholder="Qty"
                        min="1"
                        required>

                    {{-- Remove --}}
                    <button
                        type="button"
                        onclick="removeItem(this)"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 rounded">

                        ✕

                    </button>

                </div>

            </div>

            <button
                type="button"
                onclick="addItem()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded mb-5">

                + Tambah Barang

            </button>

            <br>

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

                Ajukan Peminjaman

            </button>

        </form>

    </div>

<script>

let index = 1;

function addItem(){

    let container = document.getElementById('items');

    let html = `
    <div class="flex gap-4 mb-3 item">

        <select
            name="products[${index}][product_id]"
            class="w-1/2 border rounded p-2 product-select"
            onchange="updateMaxQty(this)"
            required>

            <option value="">
                -- Pilih Produk --
            </option>

            @foreach($products as $product)

            <option
                value="{{ $product->id }}"
                data-stock="{{ $product->stock }}"
                {{ $product->stock == 0 ? 'disabled' : '' }}>

                {{ $product->name }}
                (stok: {{ $product->stock }})

            </option>

            @endforeach

        </select>

        <input
            type="number"
            name="products[${index}][qty]"
            class="w-1/4 border rounded p-2 qty-input"
            placeholder="Qty"
            min="1"
            required>

        <button
            type="button"
            onclick="removeItem(this)"
            class="bg-red-500 hover:bg-red-600 text-white px-3 rounded">

            ✕

        </button>

    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);

    index++;

}

function removeItem(button){

    let items = document.querySelectorAll('.item');

    if(items.length == 1){

        alert('Minimal harus ada satu barang.');

        return;

    }

    button.parentElement.remove();

}

function updateMaxQty(select){

    let stock = select.options[select.selectedIndex].dataset.stock;

    let qtyInput = select.parentElement.querySelector('.qty-input');

    if(stock){

        qtyInput.max = stock;

        qtyInput.placeholder = "Max : " + stock;

        if(qtyInput.value > stock){

            qtyInput.value = stock;

        }

    }

}

</script>

</x-app-layout>