<!DOCTYPE html>
<html
    class="h-full"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <title>{{ config('app.name') }}</title>
    @include('layouts.meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="flex relative min-h-full font-sans antialiased bg-slate-200 dark:bg-slate-950"

    x-cloak
    x-data="{
        date: '',
        currentTime: 'checking the time',
        theme: false,
        toggleTheme() {
            if (localStorage.theme === 'dark') {
                localStorage.setItem('theme', 'light')
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.setItem('theme', 'dark')
                document.documentElement.classList.add('dark');
            }
        },
        checkTheme() {
            if (localStorage.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="setInterval(() => {
        date = new Date()
        currentTime = date.toLocaleString()
    }, 1000);
    theme = localStorage.getItem('theme');
    checkTheme();
    $watch('theme', () => toggleTheme());"
>


    <main class="w-full h-full">

        @if( !app()->environment('production'))
            <div class="p-2 m-1 w-screen text-center bg-green-600 text-[10px]">
                <p class="font-bold text-white whitespace-nowrap">This is the training environment</p>
            </div>
        @endif

        @php
            $salutation = ['Hi, ', 'Howzit, ', 'Wazup, ', 'Hello, ', 'Hey there, '];
        @endphp

        <nav
            class="sticky top-0 z-40 w-full bg-white border-t-4 shadow-md border-sky-400 backdrop-blur dark:border-sky-500 dark:bg-slate-950"
        >
            <div class="flex justify-between items-center py-1 px-1 mx-auto md:px-8 text-slate-500 max-w-8xl dark:text-slate-300">
                <p class="text-xs font-bold">{{ $salutation[rand(0, 4)] }}
                    <span>
                        {{ request()->user()->name }}
                    </span>
                </p>
                <div>
                    <p
                        class="text-xs font-semibold"
                        x-text="currentTime"
                    ></p>
                </div>
            </div>
            <div class="px-2 mx-auto sm:px-6 md:px-8 max-w-8xl">
                <div class="flex justify-center items-center w-full lg:justify-between">
                    <div class="flex items-center py-2 lg:justify-between lg:py-1">
                        <container
                            class="hidden items-center px-4 mx-auto space-x-8 lg:flex lg:py-2 lg:pb-1 lg:max-w-7xl"
                        >
                            <livewire:users.default-sales-channel />

                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('dashboard') }}"
                            >dashboard</a>

                            @hasPermissionTo('view orders')
                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('orders') }}"
                            >orders</a>
                            @endhasPermissionTo

                            @hasPermissionTo('view products')
                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('products') }}"
                            >products</a>
                            @endhasPermissionTo

                            @hasPermissionTo('view customers')
                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('customers') }}"
                            >customers</a>
                            @endhasPermissionTo

                            @hasPermissionTo('view warehouse')
                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('warehouse') }}"
                            >warehouse</a>
                            @endhasPermissionTo

                            @hasPermissionTo('view settings')
                            <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                               href="{{ route('settings') }}"
                            >admin</a>
                            @endhasPermissionTo
                        </container>
                    </div>
                    <div class="flex overflow-y-hidden overflow-x-scroll items-baseline py-1 pr-4 pb-3 space-x-8 lg:py-1 no-scrollbar">

                        @if (request()->user()->sales_channels_count > 1)
                            <div class="whitespace-nowrap">
                                <livewire:users.sales-channel-change-button />
                            </div>
                        @endif

                        <div class="whitespace-nowrap">
                            <livewire:orders.quick-toggle-button />
                        </div>

                        <div class="whitespace-nowrap">
                            <livewire:customers.quick-customer-button />
                        </div>

                        <div class="whitespace-nowrap">
                            <button
                                class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                                x-on:click="document.getElementById('logout-form').submit()"
                            >Sign out
                            </button>

                            <form
                                class="hidden"
                                id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                            >@csrf</form>
                        </div>

                        <div class="whitespace-nowrap">
                            <button
                                x-on:click="theme = !theme"
                                class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                            >
                                <span x-show="theme">Light mode</span>
                                <span x-show="!theme">Dark mode</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="items-center w-full">
                <container
                    class="flex overflow-x-scroll items-center py-4 px-2 mx-auto space-x-6 border-t lg:hidden lg:py-2 lg:pb-1 lg:max-w-7xl no-scrollbar border-sky-400/50"
                >
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('dashboard') }}"
                    >dashboard</a>

                    @hasPermissionTo('view orders')
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('orders') }}"
                    >orders</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view products')
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('products') }}"
                    >products</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view customers')
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('customers') }}"
                    >customers</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view warehouse')
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('warehouse') }}"
                    >warehouse</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view settings')
                    <a class="text-sm font-extrabold tracking-wider uppercase hover:underline text-sky-800 dark:text-sky-600 hover:underline-offset-1"
                       href="{{ route('settings') }}"
                    >admin</a>
                    @endhasPermissionTo
                </container>
            </div>
        </nav>

        <div class="relative px-2 pt-4 pb-12 mx-auto lg:px-4 max-w-8xl">
            <livewire:users.sales-channel-change />
            <livewire:customers.create />
            <livewire:orders.quick />
            <x-notification />
            {{ $slot }}
        </div>

    </main>

    @livewireScripts
</body>

</html>
