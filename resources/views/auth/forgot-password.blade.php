<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-slate-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4"
            :status="session('status')"
        />

        <form
            method="POST"
            action="{{ route('password.email') }}"
        >
            @csrf

            <!-- Email Address -->
            <div>

                <x-input.label for="email">
                    email
                </x-input.label>
                <x-input.text
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    required
                    autofocus
                />
            </div>

            <div class="flex justify-end items-center mt-4">
                <button class="button-success">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
