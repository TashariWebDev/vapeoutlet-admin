<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-slate-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors
            class="mb-4"
            :errors="$errors"
        />

        <form
            method="POST"
            action="{{ route('password.confirm') }}"
        >
            @csrf

            <!-- Password -->
            <div>

                <x-input.text
                    class="block mt-1 w-full"
                    id="password"
                    name="password"
                    type="password"
                    label="password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="flex justify-end mt-4">
                <button class="button-success">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
