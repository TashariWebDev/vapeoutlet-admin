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
    class="flex relative min-h-full font-sans antialiased bg-slate-200 dark:bg-slate-800"
    x-data="{
        showMenu: false,
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

    <aside
        class="fixed z-50 px-1 w-20 h-screen text-xs bg-white shadow lg:block dark:bg-slate-900"
        x-show="showMenu"
        x-on:click.outside="showMenu = !showMenu"
        x-transition:enter-start="w-0"
        x-transition:enter-end="w-full duration-300"
        x-transition:leave-start="w-full"
        x-transition:leave-end="w-0 duration-300"
        x-cloak
    >
        <div class="w-full h-16">
            <x-application-logo class="px-2 w-full h-full" />
        </div>

        <div class="overflow-y-auto">
            <ul>
                <li>
                    <a
                        class="flex flex-col items-center p-3 w-full text-xs group"
                        href="{{ route('dashboard') }}"
                    >
                        <x-icons.home
                            class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                        />
                        <span
                            class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                        >Home</span>
                    </a>
                </li>

                @hasPermissionTo('view orders')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('orders') }}"
                        >
                            <x-icons.shopping-bag
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Orders</span>
                        </a>
                    </li>
                @endhasPermissionTo

                @hasPermissionTo('view products')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('products') }}"
                        >
                            <x-icons.products
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Products</span>
                        </a>
                    </li>
                @endhasPermissionTo

                @hasPermissionTo('view customers')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('customers') }}"
                        >
                            <x-icons.users
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Customers</span>
                        </a>
                    </li>
                @endhasPermissionTo

                @hasPermissionTo('view inventory')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('inventory') }}"
                        >
                            <x-icons.inventory
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Inventory</span>
                        </a>
                    </li>
                @endhasPermissionTo

                @hasPermissionTo('view warehouse')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('warehouse') }}"
                        >
                            <x-icons.warehouse
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Warehouse</span>
                        </a>
                    </li>
                @endhasPermissionTo

                @hasPermissionTo('view settings')
                    <li>
                        <a
                            class="flex flex-col items-center p-3 w-full text-xs group"
                            href="{{ route('settings') }}"
                        >
                            <x-icons.settings
                                class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            />
                            <span
                                class="font-bold text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-300 group-hover:text-slate-800"
                            >Admin</span>
                        </a>
                    </li>
                @endhasPermissionTo
            </ul>
        </div>
    </aside>

    <main class="w-full h-full">

        @php
            $salutation = ['Hi, ', 'Howzit, ', 'Wazup, ', 'Hello, ', 'Hey there, '];
        @endphp

        <header class="flex fixed z-40 justify-between items-center w-full h-12 bg-white dark:bg-slate-900">
            <div class="flex items-center px-2 lg:px-4">
                <button x-on:click="showMenu = !showMenu">
                    <x-icons.menu
                        class="w-6 h-6 text-slate-500 dark:text-slate-500 dark:hover:text-slate-300 hover:text-slate-800"
                    />
                </button>

                <div class="hidden pl-3 lg:block text-slate-500 dark:text-slate-500">
                    <p class="text-xs font-bold">{{ $salutation[rand(0, 4)] }}
                        <span class="text-green-600 cursor-default">{{ auth()->user()->name }}</span>
                    </p>
                    <p
                        class="text-xs font-semibold"
                        x-text="currentTime"
                    ></p>
                </div>
            </div>
            <div class="flex items-center px-2 space-x-2 lg:px-4">

                <livewire:components.quick-customer />
                <livewire:components.quick-order />

                <div
                    class="flex justify-center items-center w-6 h-6 rounded-full border ring-2 shadow-2xl ring-slate-100 dark:ring-slate-800 dark:border-slate-900">
                    <button x-on:click="theme = !theme">
                        <x-icons.moon
                            class="w-4 h-4 text-slate-500 dark:text-slate-500 dark:hover:text-slate-300 hover:text-slate-800"
                            x-show="theme"
                        />
                    </button>
                    <button x-on:click="theme = !theme">
                        <x-icons.sun
                            class="w-4 h-4 text-slate-500 dark:text-slate-500 dark:hover:text-slate-300 hover:text-slate-800"
                            x-show="!theme"
                        />
                    </button>
                </div>

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
        </header>

        <div class="relative py-6 px-2 mt-16 lg:px-4">
            <x-notification />
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>

</html>
