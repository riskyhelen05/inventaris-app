<x-guest-layout>

    <div class="text-center mb-6">

        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100">

            <x-heroicon-o-envelope class="w-7 h-7 text-red-600"/>

        </div>

        <h2 class="mt-4 text-2xl font-bold text-slate-800">
            Lupa Password?
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

    </div>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">

        @csrf

        <div>

            <x-input-label
                for="email"
                value="Email"/>

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="block mt-2 w-full rounded-xl"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"/>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"/>

        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-red-600 py-3 font-semibold text-white transition hover:bg-red-700">

            Kirim Link Reset Password

        </button>

    </form>

</x-guest-layout>