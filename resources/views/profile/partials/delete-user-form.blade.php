<section class="space-y-6">

    <header>
        <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-500"/>
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-slate-500 max-w-xl">
            Setelah akun dihapus, semua data akan hilang permanen. 
            Pastikan kamu sudah membackup data penting.
        </p>
    </header>

    {{-- BUTTON --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow transition">

        <x-heroicon-o-trash class="w-4 h-4"/>
        Hapus Akun
    </button>

    {{-- MODAL --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <div class="flex items-start gap-3">
                <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-500 mt-1"/>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Konfirmasi Hapus Akun
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tindakan ini tidak bisa dibatalkan. Semua data akan dihapus permanen.
                    </p>
                </div>
            </div>

            {{-- INPUT PASSWORD --}}
            <div>
                <x-input-label for="password" value="Password" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg"
                    placeholder="Masukkan password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-100">
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 flex items-center gap-2">

                    <x-heroicon-o-trash class="w-4 h-4"/>
                    Hapus Permanen

                </button>

            </div>

        </form>

    </x-modal>

</section>