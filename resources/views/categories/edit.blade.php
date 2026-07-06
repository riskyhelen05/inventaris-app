<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 rounded-lg p-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-4">
                <h3 class="text-lg font-semibold">
                    Form Edit Kategori
                </h3>
            </div>

            <form action="{{ route('categories.update',$category->id) }}"
                  method="POST"
                  class="p-6 space-y-6">

                @csrf
                @method('PUT')

                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$category->name) }}"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        required>

                </div>

                <div class="flex justify-end gap-3">

                    <a href="{{ route('categories.index') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                        Batal
                    </a>

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>
</x-app-layout>