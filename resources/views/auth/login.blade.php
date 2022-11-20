<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4"
            :status="session('status')"
        />

        <!-- Validation Errors -->

        <form
            method="POST"
            action="{{ route('login') }}"
        >
            @csrf

            <!-- Email Address -->
            <div>
                <x-form.input.label for="email">
                    Email
                </x-form.input.label>
                <x-form.input.text
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    required
                    autofocus
                />
                @error('email')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-form.input.label for="password">
                    Password
                </x-form.input.label>
                <x-form.input.text
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                />
                @error('password')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label
                    class="inline-flex items-center"
                    for="remember_me"
                >
                    <input
                        class="text-pink-600 rounded shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 border-slate-300"
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        label=""
                    >
                    <span class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex justify-end items-center mt-4">
                @if (Route::has('password.request'))
                    <a
                        class="mr-3 link"
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button class="w-20 button-success">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
