<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-slate-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-slate-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-medium text-sky-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex justify-between items-center mt-4">
            <form
                method="POST"
                action="{{ route('verification.send') }}"
            >
                @csrf

                <div>
                    <button class="button-success">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    class="text-sm underline text-slate-600 hover:text-slate-900"
                    type="submit"
                >
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
