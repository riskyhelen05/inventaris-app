<x-app-layout>

<x-slot name="header">
    Tambah Produk
</x-slot>

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-300 bg-red-50 p-4">

            <h3 class="font-semibold text-red-700 mb-2">
                Terjadi Kesalahan
            </h3>

            <ul class="list-disc list-inside text-sm text-red-600">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif

    <form action="{{ route('products.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- FORM --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm">

                <div class="border-b px-6 py-4">

                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-clipboard-document class="w-5 h-5 text-red-600"/>
                        Informasi Produk
                    </h3>

                </div>

                <div class="p-6 grid md:grid-cols-2 gap-5">

                    {{-- KODE --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Barang
                        </label>

                        <input
                            type="text"
                            name="kode_barang"
                            value="{{ old('kode_barang') }}"
                            class="w-full rounded-xl border-gray-300 py-2.5 focus:ring-red-500 focus:border-red-500"
                            required>

                    </div>

                    {{-- NAMA --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-xl border-gray-300 py-2.5 focus:ring-red-500 focus:border-red-500"
                            required>

                    </div>

                    {{-- KATEGORI --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            class="w-full rounded-xl border-gray-300 py-2.5"
                            required>

                            <option value="">
                                Pilih Kategori
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id')==$category->id?'selected':'' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- STOK --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok
                        </label>

                        <input
                            type="number"
                            min="0"
                            name="stock"
                            value="{{ old('stock') }}"
                            class="w-full rounded-xl border-gray-300 py-2.5"
                            required>

                    </div>

                    {{-- LOKASI --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Penyimpanan
                        </label>

                        <input
                            type="text"
                            name="location"
                            value="{{ old('location') }}"
                            class="w-full rounded-xl border-gray-300 py-2.5"
                            required>

                    </div>

                    {{-- KONDISI --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi
                        </label>

                        <select
                            name="condition"
                            class="w-full rounded-xl border-gray-300 py-2.5">

                            <option value="">
                                Pilih Kondisi
                            </option>

                            <option value="baik">
                                Baik
                            </option>

                            <option value="rusak">
                                Rusak
                            </option>

                            <option value="servis">
                                Servis
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            {{-- FOTO --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm h-full">

                <div class="border-b px-6 py-4">

                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">

                        <x-heroicon-o-photo class="w-5 h-5 text-red-600"/>
                        Gambar Produk

                    </h3>

                </div>

            <div class="p-6 flex flex-col items-center">

                <img
                    id="preview"
                    src="https://placehold.co/300x300?text=No+Image"
                    class="w-40 h-40 rounded-xl border object-cover">

                <label
                    for="image"
                    class="mt-5 w-full border-2 border-dashed border-gray-300 rounded-xl p-2 text-center cursor-pointer hover:border-red-500 transition">

                <div class="text-4xl">
                    <x-heroicon-o-arrow-up-on-square class="w-8 h-8 mx-auto text-slate-400"/>
                </div>

                <p class="mt-2 font-medium text-gray-700">
                    Klik untuk memilih gambar
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    JPG / PNG • Maksimal 2 MB
                </p>

                </label>

            <input
                id="image"
                type="file"
                name="image"
                accept="image/*"
                class="hidden">

        </div>

    </div>

</div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 mt-8">

            <a href="{{ route('products.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 border text-gray-700">

                Batal

            </a>

            <button
                class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium shadow">

                Simpan Produk

            </button>

        </div>

    </form>

</div>

<script>

document.getElementById('image').onchange = function(e){

    const reader = new FileReader();

    reader.onload = function(){

        document.getElementById('preview').src = reader.result;

    }

    reader.readAsDataURL(e.target.files[0]);

}

</script>

</x-app-layout>