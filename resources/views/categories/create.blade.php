<x-app-layout>

<x-slot name="header">
    Tambah Kategori
</x-slot>

    <div class="max-w-2xl mx-auto p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">
                <ul class="list-disc ml-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-700">
                    Form Tambah Kategori
                </h3>
                <p class="text-sm text-gray-500">
                    Gunakan nama kategori untuk mengelompokkan barang
                </p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('categories.store') }}"
                  method="POST"
                  class="p-6 space-y-6">

                @csrf

                {{-- INPUT --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Elektronik, ATK, Furniture"
                        class="w-full h-11 rounded-xl border-gray-300 text-sm 
                               focus:border-red-500 focus:ring-1 focus:ring-red-500 transition"
                        required>
                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-2 pt-4 border-t">

                    <a href="{{ route('categories.index') }}"
                        class="px-4 h-10 flex items-center rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button
                        class="px-5 h-10 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition shadow-sm">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>
</x-app-layout>