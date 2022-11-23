<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors
            class="mb-4"
            :errors="$errors"
        />

        <form
            method="POST"
            action="{{ route('register') }}"
        >
            @csrf

            <!-- Name -->
            <div>

                <x-input.text
                    class="block mt-1 w-full"
                    id="name"
                    name="name"
                    type="text"
                    label="name"
                    :value="old('name')"
                    required
                    autofocus
                />
            </div>

            <!-- Email Address -->
            <div class="mt-4">

                <x-input.text
                    class="block mt-1 w-full"
                    id="email"
                    name="email"
                    type="email"
                    label="email"
                    :value="old('email')"
                    required
                />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input.label for="password"></x-input.label>

                <x-input.text
                    class="block mt-1 w-full"
                    id="password"
                    name="password"
                    type="password"
                    label="password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">

                <x-input.text
                    class="block mt-1 w-full"
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    label="confirm password"
                    required
                />
            </div>

            <div class="flex justify-end items-center mt-4">
                <a
                    class="text-sm underline text-slate-600 hover:text-slate-900"
                    href="{{ route('login') }}"
                >
                    {{ __('Already registered?') }}
                </a>

                <button class="ml-4 button-success">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
