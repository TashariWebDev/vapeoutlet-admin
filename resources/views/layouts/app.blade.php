<!DOCTYPE html>
<html
    class="h-full"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <meta
        name=”robots”
        content=”noindex”
    >

    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="flex relative min-h-full font-sans antialiased bg-slate-200 dark:bg-slate-900"
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

        @php
            $salutation = ['Hi, ', 'Howzit, ', 'Wazup, ', 'Hello, ', 'Hey there, '];
        @endphp

        <nav
            class="sticky top-0 z-40 w-full border-t-4 border-teal-400 dark:bg-transparent dark:border-teal-500 bg-white/60 backdrop-blur">
            <div class="px-4 mx-auto sm:px-6 md:px-8 max-w-8xl">
                <div class="flex justify-center items-center w-full lg:justify-between">
                    <div class="flex items-center py-4">
                        <div class="hidden pl-3 lg:block text-slate-500 dark:text-slate-500">
                            <p class="text-xs font-bold">{{ $salutation[rand(0, 4)] }}
                                <span class="cursor-default">{{ auth()->user()->name }}</span>
                            </p>
                            <div class="flex space-x-4">
                                <p
                                    class="text-xs font-semibold"
                                    x-text="currentTime"
                                ></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div>
                            <livewire:orders.quick-toggle-button />
                        </div>
                        <div>
                            <livewire:customers.quick-customer-button />
                        </div>

                        <div>
                            <button
                                class="link"
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

                        <div
                            class="flex justify-center items-center w-6 h-6 rounded-full border border-teal-400 ring-2 ring-slate-100 dark:ring-slate-800">
                            <button x-on:click="theme = !theme">
                                <x-icons.moon
                                    class="w-4 h-4 text-slate-900 dark:text-slate-400 dark:hover:text-slate-300 hover:text-slate-800"
                                    x-show="theme"
                                />
                            </button>
                            <button x-on:click="theme = !theme">
                                <x-icons.sun
                                    class="w-4 h-4 text-slate-900 dark:text-slate-400 dark:hover:text-slate-300 hover:text-slate-800"
                                    x-show="!theme"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items-center w-full">
                <container
                    class="flex overflow-x-scroll items-center py-4 px-4 mx-auto space-x-6 border-t lg:py-2 lg:pb-1 lg:max-w-7xl border-teal-400/50"
                >
                    <a
                        class="link"
                        href="{{ route('dashboard') }}"
                    >dashboard</a>

                    @hasPermissionTo('view orders')
                        <a
                            class="link"
                            href="{{ route('orders') }}"
                        >orders</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view products')
                        <a
                            class="link"
                            href="{{ route('products') }}"
                        >products</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view customers')
                        <a
                            class="link"
                            href="{{ route('customers') }}"
                        >customers</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view warehouse')
                        <a
                            class="link"
                            href="{{ route('warehouse') }}"
                        >warehouse</a>
                    @endhasPermissionTo

                    @hasPermissionTo('view settings')
                        <a
                            class="link"
                            href="{{ route('settings') }}"
                        >admin</a>
                    @endhasPermissionTo
                </container>
            </div>
        </nav>

        <div class="relative py-8 px-2 mx-auto lg:px-6 max-w-8xl">
            <livewire:customers.create />
            <livewire:orders.quick />
            <x-notification />
            {{ $slot }}
        </div>

    </main>

    @livewireScripts
</body>

</html>
