<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Edit Produk
            </h2>
            <p class="text-gray-500 text-sm">
                Perbarui informasi produk inventaris
            </p>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4">
                <h3 class="font-semibold text-red-700 mb-2">
                    Terjadi Kesalahan
                </h3>

                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('products.update',$product->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- FORM --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">

                    <h3 class="text-lg font-semibold text-red-600 mb-6">
                        Informasi Produk
                    </h3>

                    <div class="grid md:grid-cols-2 gap-5">

                        {{-- KODE --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Kode Barang
                            </label>

                            <input
                                type="text"
                                name="kode_barang"
                                value="{{ old('kode_barang',$product->kode_barang) }}"
                                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-red-500"
                                required>

                        </div>


                        {{-- NAMA --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Nama Barang
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name',$product->name) }}"
                                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-red-500"
                                required>

                        </div>


                        {{-- KATEGORI --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Kategori
                            </label>

                            <select
                                name="category_id"
                                class="w-full border rounded-lg p-3"
                                required>

                                <option value="">
                                    Pilih Kategori
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id',$product->category_id)==$category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- STOCK --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Stock
                            </label>

                            <input
                                type="number"
                                name="stock"
                                min="0"
                                value="{{ old('stock',$product->stock) }}"
                                class="w-full border rounded-lg p-3"
                                required>

                        </div>


                        {{-- LOKASI --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Lokasi Penyimpanan
                            </label>

                            <input
                                type="text"
                                name="location"
                                value="{{ old('location',$product->location) }}"
                                class="w-full border rounded-lg p-3"
                                required>

                        </div>


                        {{-- KONDISI --}}
                        <div>

                            <label class="block mb-2 font-medium">
                                Kondisi
                            </label>

                            <select
                                name="condition"
                                class="w-full border rounded-lg p-3">

                                <option
                                    value="baik"
                                    {{ old('condition',$product->condition)=='baik' ? 'selected' : '' }}>

                                    Baik

                                </option>

                                <option
                                    value="rusak"
                                    {{ old('condition',$product->condition)=='rusak' ? 'selected' : '' }}>

                                    Rusak

                                </option>

                            </select>

                        </div>

                    </div>

                </div>



                {{-- FOTO --}}
                <div class="bg-white rounded-xl shadow p-6">

                    <h3 class="text-lg font-semibold text-red-600 mb-5">
                        Gambar Produk
                    </h3>

                    <div class="flex justify-center">

                        @if($product->image)

                            <img
                                id="preview"
                                src="{{ asset('storage/'.$product->image) }}"
                                class="w-64 h-64 rounded-lg border object-cover">

                        @else

                            <img
                                id="preview"
                                src="https://placehold.co/300x300?text=No+Image"
                                class="w-64 h-64 rounded-lg border object-cover">

                        @endif

                    </div>


                    <div class="mt-6">

                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept="image/*"
                            class="w-full border rounded-lg p-2">

                    </div>

                    <p class="text-xs text-gray-500 mt-3">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </p>

                </div>

            </div>


            <div class="mt-8 flex justify-end gap-3">

                <a
                    href="{{ route('products.index') }}"
                    class="px-6 py-3 rounded-lg bg-gray-300 hover:bg-gray-400">

                    Batal

                </a>

                <button
                    class="px-6 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white shadow">

                    Update Produk

                </button>

            </div>

        </form>

    </div>

<script>

document.getElementById('image').addEventListener('change', function(e){

    const reader = new FileReader();

    reader.onload = function(){

        document.getElementById('preview').src = reader.result;

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>

</x-app-layout>