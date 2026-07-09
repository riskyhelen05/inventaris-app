<x-guest-layout>

    <div class="text-center mb-8">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100">

            <x-heroicon-o-user-plus class="w-8 h-8 text-red-600"/>

        </div>

        <h2 class="mt-5 text-3xl font-bold text-slate-800">
            Buat Akun Baru
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Daftarkan akun untuk mulai menggunakan
            <span class="font-semibold text-red-600">AssetTrack</span>.
        </p>

    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">

        @csrf

        <!-- Nama -->
        <div>

            <x-input-label
                for="name"
                value="Nama Lengkap"/>

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-2 block w-full rounded-xl"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"/>

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"/>

        </div>

        <!-- Email -->
        <div>

            <x-input-label
                for="email"
                value="Email"/>

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-2 block w-full rounded-xl"
                :value="old('email')"
                required
                autocomplete="username"/>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"/>

        </div>

        <!-- Password -->
        <div>

            <x-input-label
                for="password"
                value="Password"/>

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-2 block w-full rounded-xl"
                required
                autocomplete="new-password"/>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"/>

        </div>

        <!-- Konfirmasi Password -->
        <div>

            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"/>

            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-2 block w-full rounded-xl"
                required
                autocomplete="new-password"/>

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"/>

        </div>

        <div class="flex items-center justify-between pt-2">

            <a href="{{ route('login') }}"
               class="text-sm font-medium text-red-600 hover:text-red-700">

                Sudah punya akun?

            </a>

            <button
                type="submit"
                class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">

                Daftar

            </button>

        </div>

    </form>

</x-guest-layout>