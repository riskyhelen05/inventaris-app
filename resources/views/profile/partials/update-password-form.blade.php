<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <x-heroicon-o-lock-closed class="w-5 h-5 text-blue-500"/>
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />

            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-heroicon-o-key class="w-5 h-5"/>
                </span>

                <x-text-input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="pl-10 block w-full"
                    autocomplete="current-password"
                />
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="password" :value="__('New Password')" />

            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-heroicon-o-lock-closed class="w-5 h-5"/>
                </span>

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="pl-10 block w-full"
                    autocomplete="new-password"
                />
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-heroicon-o-check-circle class="w-5 h-5"/>
                </span>

                <x-text-input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="pl-10 block w-full"
                    autocomplete="new-password"
                />
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button class="flex items-center gap-2">
                <x-heroicon-o-check class="w-5 h-5"/>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
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