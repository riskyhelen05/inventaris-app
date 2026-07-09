<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <x-heroicon-o-user class="w-5 h-5 text-blue-500"/>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Verification Form --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Main Form --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-heroicon-o-user class="w-5 h-5"/>
                </span>

                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="pl-10 block w-full"
                    :value="old('name', $user->name)"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-heroicon-o-envelope class="w-5 h-5"/>
                </span>

                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="pl-10 block w-full"
                    :value="old('email', $user->email)"
                    required
                    autocomplete="username"
                />
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email Verification --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-lg bg-yellow-50 border border-yellow-200">
                    <p class="text-sm text-yellow-800 flex items-center gap-2">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5"/>
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button form="send-verification"
                        class="mt-2 inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
                        <x-heroicon-o-paper-airplane class="w-4 h-4"/>
                        {{ __('Resend verification email') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 flex items-center gap-1">
                            <x-heroicon-o-check-circle class="w-4 h-4"/>
                            {{ __('Verification link sent!') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button class="flex items-center gap-2">
                <x-heroicon-o-check class="w-5 h-5"/>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 flex items-center gap-1"
                >
                    <x-heroicon-o-check-circle class="w-4 h-4"/>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>