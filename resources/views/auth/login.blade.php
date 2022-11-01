<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500"/>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4"
                               :status="session('status')"
        />

        <!-- Validation Errors -->

        <form method="POST"
              action="{{ route('login') }}"
        >
            @csrf

            <!-- Email Address -->
            <div>
                <x-input id="email"
                         label="email"
                         type="email"
                         name="email"
                         :value="old('email')"
                         required
                         autofocus
                />
            </div>

            <!-- Password -->
            <div class="mt-4">

                <x-input label="password"
                         id="password"
                         type="password"
                         name="password"
                         required
                         autocomplete="current-password"
                />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me"
                       class="inline-flex items-center"
                >
                    <input label=""
                           id="remember_me"
                           type="checkbox"
                           class="rounded border-slate-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                           name="remember"
                    >
                    <span class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-slate-600 hover:text-slate-900"
                       href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
