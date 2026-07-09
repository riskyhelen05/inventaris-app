<x-guest-layout>

    <div class="text-center mb-6">

        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100">

            <x-heroicon-o-lock-closed class="w-7 h-7 text-red-600"/>

        </div>

        <h2 class="mt-4 text-2xl font-bold text-slate-800">
            Konfirmasi Password
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Demi keamanan akun, silakan masukkan password Anda untuk melanjutkan.
        </p>

    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">

        @csrf

        <div>

            <x-input-label
                for="password"
                value="Password"
                class="mb-2"/>

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="block w-full rounded-xl"
                required
                autocomplete="current-password"/>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"/>

        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-red-600 py-3 font-semibold text-white hover:bg-red-700 transition">

            Konfirmasi Password

        </button>

    </form>

</x-guest-layout>