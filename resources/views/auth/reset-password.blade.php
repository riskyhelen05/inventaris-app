<x-guest-layout>

    <div class="text-center mb-8">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100">

            <x-heroicon-o-key class="w-8 h-8 text-red-600"/>

        </div>

        <h2 class="mt-5 text-3xl font-bold text-slate-800">
            Reset Password
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Masukkan email dan password baru untuk akun
            <span class="font-semibold text-red-600">AssetTrack</span>.
        </p>

    </div>

    <form method="POST"
          action="{{ route('password.store') }}"
          class="space-y-5">

        @csrf

        <!-- Token -->
        <input type="hidden"
               name="token"
               value="{{ $request->route('token') }}">

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
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"/>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"/>

        </div>

        <!-- Password Baru -->
        <div>

            <x-input-label
                for="password"
                value="Password Baru"/>

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

        <!-- Konfirmasi -->
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

        <button
            type="submit"
            class="w-full rounded-xl bg-red-600 py-3 font-semibold text-white transition hover:bg-red-700">

            Reset Password

        </button>

    </form>

</x-guest-layout>