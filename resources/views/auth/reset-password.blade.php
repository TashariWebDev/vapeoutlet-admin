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
            action="{{ route('password.update') }}"
        >
            @csrf

            <!-- Password Reset Token -->
            <input
                name="token"
                type="hidden"
                value="{{ $request->route('token') }}"
            >

            <!-- Email Address -->
            <div>

                <x-input.text
                    class="block mt-1 w-full"
                    id="email"
                    name="email"
                    type="email"
                    label="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                />
            </div>

            <!-- Password -->
            <div class="mt-4">

                <x-input.text
                    class="block mt-1 w-full"
                    id="password"
                    name="password"
                    type="password"
                    label="password"
                    required
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
                <button class="button-success">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
