<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name=”robots” content=”noindex”>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased h-full overflow-hidden bg-gray-100">

<div class="h-full flex" x-data="{showMobileMenu: false}">
    <!-- Narrow sidebar -->
    <div class="hidden w-28 bg-gradient-gray overflow-y-auto md:block">
        <div class="w-full py-6 flex flex-col items-center">

            <div class="flex-shrink-0 flex items-center">
                <x-application-logo class="w-16"/>
            </div>

            {{--desktop sidebar links--}}
            <div class="flex-1 mt-6 w-full px-2 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                   @if( str_contains(request()->path(),'dashboard') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.home/>
                    <span class="mt-2">Home</span>
                </a>

                @hasPermissionTo('view orders')
                <a href="{{ route('orders') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                   @if( str_contains(request()->path(),'orders') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.shopping-bag/>
                    <span class="mt-2">Orders</span>
                </a>
                @endhasPermissionTo

                @hasPermissionTo('view products')
                <a href="{{route('products')}}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                   @if( str_contains(request()->path(),'products') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.products/>
                    <span class="mt-2">Products</span>
                </a>
                @endhasPermissionTo

                @hasPermissionTo('view customers')
                <a href="{{ route('customers') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                   @if( str_contains(request()->path(),'customers') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.users/>
                    <span class="mt-2">Customers</span>
                </a>
                @endhasPermissionTo

                @hasPermissionTo('view inventory')
                <a href="{{ route('inventory') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                   @if( str_contains(request()->path(),'inventory') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.inventory/>
                    <span class="mt-2">Inventory</span>
                </a>
                @endhasPermissionTo

                @hasPermissionTo('view warehouse')
                <a href="{{ route('warehouse') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                                   @if( str_contains(request()->path(),'warehouse') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.warehouse/>
                    <span class="mt-2">Warehouse</span>
                </a>
                @endhasPermissionTo

                @hasPermissionTo('view dispatch')
                <a href="{{ route('dispatch') }}"
                   class="group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium
                       @if( str_contains(request()->path(),'dispatch') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                       ">
                    <x-icons.truck/>
                    <span class="mt-2">Dispatch</span>
                </a>
                @endhasPermissionTo

            </div>
        </div>
    </div>

    {{--    Mobile menu--}}
    <div class="relative z-20 md:hidden" role="dialog" aria-modal="true"
         x-cloak
         x-show="showMobileMenu"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    >
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex"
             x-cloak
             x-show="showMobileMenu"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
        >
            <div class="relative max-w-xs w-full bg-gradient-gray pt-5 pb-4 flex-1 flex flex-col"
                 x-cloak
                 x-show="showMobileMenu"
                 x-transition:enter="ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
            >
                <div class="absolute top-1 right-0 -mr-14 p-1">
                    <button type="button"
                            class="h-12 w-12 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-white"
                            x-on:click="showMobileMenu = !showMobileMenu"
                    >
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="sr-only">Close sidebar</span>
                    </button>
                </div>

                <div class="flex-shrink-0 px-4 flex items-center">
                    <x-application-logo class="h-8 w-auto"/>
                </div>
                <div class="mt-5 flex-1 h-0 px-2 overflow-y-auto">
                    <nav class="h-full flex flex-col">
                        <div class="space-y-1">

                            <a href="{{ route('dashboard') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if( str_contains(request()->path(),'dashboard') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.home class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Home</span>
                            </a>

                            @hasPermissionTo('view orders')
                            <a href="{{ route('orders') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if( str_contains(request()->path(),'orders') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.shopping-bag class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Orders</span>
                            </a>
                            @endhasPermissionTo

                            @hasPermissionTo('view products')
                            <a href="{{ route('products') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if( str_contains(request()->path(),'products') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.products class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Products</span>
                            </a>
                            @endhasPermissionTo

                            @hasPermissionTo('view customers')
                            <a href="{{ route('customers') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if( str_contains(request()->path(),'customers') ) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.users class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Customers</span>
                            </a>
                            @endhasPermissionTo

                            @hasPermissionTo('view inventory')
                            <a href="{{ route('inventory') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if(  str_contains(request()->path(),'inventory') )) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.inventory class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Inventory</span>
                            </a>
                            @endhasPermissionTo


                            @hasPermissionTo('view warehouse')
                            <a href="{{ route('warehouse') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if(  str_contains(request()->path(),'warehouse') )) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.warehouse class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Warehouse</span>
                            </a>
                            @endhasPermissionTo

                            @hasPermissionTo('view dispatch')
                            <a href="{{ route('dispatch') }}"
                               class="group py-2 px-3 rounded-md flex items-center text-sm font-medium
                               @if(  str_contains(request()->path(),'dispatch') )) bg-red-700 text-white @else text-white hover:bg-gray-700 hover:text-white @endif
                                   ">
                                <x-icons.truck class="text-white group-hover:text-white mr-3 h-6 w-6"/>
                                <span>Dispatch</span>
                            </a>
                            @endhasPermissionTo

                        </div>
                    </nav>
                </div>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Content area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="w-full" x-data="{showProfileMenu:false}">
            <div class="relative z-10 flex-shrink-0 h-16 bg-gray-900 flex">
                <button type="button"
                        class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                        x-on:click="showMobileMenu = !showMobileMenu"
                >
                    <span class="sr-only">Open sidebar</span>
                    <!-- Heroicon name: outline/menu-alt-2 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </button>
                <div class="flex-1 flex items-center justify-between px-4 sm:px-6"
                     x-data="{ date:'', currentTime: ''}"
                     x-init="setInterval(() => {
                                        date = new Date()
                                        currentTime = date.toLocaleString()
                                    }, 1000);"
                >
                    <div class="flex-1 flex">
                        <div>
                            <p class="text-white capitalize">{{ request()->path() }}</p>
                            <p class="text-xs opacity-60 text-gray-200 hidden md:block font-mono"
                               x-text="currentTime">
                            </p>
                        </div>
                    </div>
                    <div class="ml-2 flex items-center space-x-4 sm:ml-6 sm:space-x-6">
                        <!-- Profile dropdown -->
                        <div class="relative flex-shrink-0">
                            <div>
                                <button type="button"
                                        class="bg-gray-700 rounded-full flex justify-center items-center  text-sm
                                        hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-8 h-8"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                        x-on:click="showProfileMenu = !showProfileMenu"
                                >
                                    <span class="sr-only">Open user menu</span>
                                    <x-icons.user class="h-6 w-6 text-gray-300 rounded-full"/>
                                </button>
                            </div>

                            <div x-cloak
                                 x-show="showProfileMenu"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transition ease-out duration-100"
                                 x-transition:enter-end="transition ease-out duration-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                 tabindex="-1">

                                <a href="{{ route('users/show',auth()->id()) }}"
                                   class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                   id="user-menu-item-0">Your Profile</a>

                                <div class="border-t border-b">

                                    @hasPermissionTo('view expenses')
                                    <a href="{{ route('expenses') }}" class="block px-4 py-2 text-sm text-gray-700"
                                       role="menuitem"
                                       tabindex="-1"
                                       id="user-menu-item-0">Expenses</a>
                                    @endhasPermissionTo

                                    @hasPermissionTo('view reports')
                                    <a href="{{ route('reports') }}" class="block px-4 py-2 text-sm text-gray-700"
                                       role="menuitem"
                                       tabindex="-1"
                                       id="user-menu-item-0">Reports</a>
                                    @endhasPermissionTo

                                    @hasPermissionTo('view users')
                                    <a href="{{ route('users') }}" class="block px-4 py-2 text-sm text-gray-700"
                                       role="menuitem"
                                       tabindex="-1"
                                       id="user-menu-item-0">Users</a>
                                    @endhasPermissionTo

                                    @hasPermissionTo('view settings')
                                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700"
                                       role="menuitem"
                                       tabindex="-1"
                                       id="user-menu-item-0">Settings</a>
                                    @endhasPermissionTo
                                </div>

                                <button onclick="logout()"
                                        class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="user-menu-item-1">Sign out
                                </button>

                                <form action="{{route('logout')}}" method="POST" id="logout-form">
                                    @csrf
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <main class="container mx-auto sm:px-6 lg:px-8 py-10 overflow-y-scroll">
            <x-notification/>
            {{ $slot }}
        </main>
    </div>

</div>
@livewireScripts
<script>
    function logout() {
        document.getElementById('logout-form').submit()
    }
</script>
<script>
    function allowOnlyNumberAndDecimals(e) {
        let str = e.target.value
        const regExp = /^(\d+(\.\d+)?)$/

    }
</script>
</body>
</html>
