<x-guest-layout>

    <div class="text-center mb-8">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100">

            <x-heroicon-o-lock-closed class="w-8 h-8 text-red-600"/>

        </div>

        <h2 class="mt-5 text-3xl font-bold text-slate-800">
            Selamat Datang
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Login ke <span class="font-semibold text-red-600">AssetTrack</span>
            untuk mengelola inventaris perusahaan.
        </p>

    </div>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-5"
        :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">

        @csrf

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
                autofocus
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
                autocomplete="current-password"/>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"/>

        </div>

        <!-- Remember -->
        <div class="flex items-center justify-between">

            <label class="inline-flex items-center">

                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-red-600 focus:ring-red-500">

                <span class="ml-2 text-sm text-slate-600">
                    Ingat Saya
                </span>

            </label>

            @if (Route::has('password.request'))

                <a href="{{ route('password.request') }}"
                   class="text-sm font-medium text-red-600 hover:text-red-700">

                    Lupa Password?

                </a>

            @endif

        </div>

        <!-- Button -->
        <button
            type="submit"
            class="w-full rounded-xl bg-red-600 py-3 font-semibold text-white transition hover:bg-red-700">

            Masuk

        </button>

    </form>

</x-guest-layout>