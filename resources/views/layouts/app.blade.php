<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >
    <meta name="csrf-token"
          content="{{ csrf_token() }}"
    >
    <meta name=”robots”
          content=”noindex”
    >

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
    >

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-full bg-slate-200 dark:bg-slate-800 font-sans antialiased relative flex"
      x-data="{showMenu: false, date:'', currentTime: 'checking the time',theme:false,
      toggleTheme(){
         if (localStorage.theme === 'dark') {
                localStorage.setItem('theme','light')
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.setItem('theme','dark')
                document.documentElement.classList.add('dark');
            }
          },
          checkTheme(){
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
        }, 1000);theme = localStorage.getItem('theme'); checkTheme(); $watch('theme',() => toggleTheme());"
>

    <aside class="h-screen w-20 bg-white dark:bg-slate-900 px-1 text-xs fixed lg:block z-50 shadow"
           x-show="showMenu"
           x-on:click.outside="showMenu = !showMenu"
           x-transition:enter-start="w-0"
           x-transition:enter-end="w-full duration-300"
           x-transition:leave-start="w-full"
           x-transition:leave-end="w-0 duration-300"
           x-cloak
    >
        <div class="w-full h-16">
            <x-application-logo class="w-full h-full px-2"/>
        </div>

        <div class="overflow-y-auto">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.home class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Home</span>
                    </a>
                </li>

                @hasPermissionTo('view orders')
                <li>
                    <a href="{{ route('orders') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.shopping-bag class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Orders</span>
                    </a>
                </li>
                @endhasPermissionTo

                @hasPermissionTo('view products')
                <li>
                    <a href="{{ route('products') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.products class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Products</span>
                    </a>
                </li>
                @endhasPermissionTo

                @hasPermissionTo('view customers')
                <li>
                    <a href="{{ route('customers') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.users class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Customers</span>
                    </a>
                </li>
                @endhasPermissionTo

                @hasPermissionTo('view inventory')
                <li>
                    <a href="{{ route('inventory') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.inventory class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Inventory</span>
                    </a>
                </li>
                @endhasPermissionTo

                @hasPermissionTo('view warehouse')
                <li>
                    <a href="{{ route('warehouse') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.warehouse class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Warehouse</span>
                    </a>
                </li>
                @endhasPermissionTo


                @hasPermissionTo('view settings')
                <li>
                    <a href="{{ route('settings') }}"
                       class="group w-full p-3 flex flex-col items-center text-xs"
                    >
                        <x-icons.settings class="text-slate-500 dark:text-slate-500 group-hover:text-slate-800 dark:group-hover:text-slate-300 w-6 h-6"/>
                        <span class="text-slate-500 group-hover:text-slate-800 dark:text-slate-500 dark:group-hover:text-slate-300 font-bold">Admin</span>
                    </a>
                </li>
                @endhasPermissionTo
            </ul>
        </div>
    </aside>

    <main class="h-full w-full">

        @php
            $salutation = ['Hi, ','Howzit, ','Wazup, ','Hello, ','Hey there, '];
        @endphp

        <header class="w-full h-12 bg-white dark:bg-slate-900 fixed z-40 flex justify-between items-center">
            <div class="px-2 lg:px-4 flex items-center">
                <button
                    x-on:click="showMenu = !showMenu"
                >
                    <x-icons.menu class="text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300 w-6 h-6"/>
                </button>

                <div class="pl-3 text-slate-500 dark:text-slate-500 hidden lg:block">
                    <p
                        class="text-xs font-bold"
                    >{{ $salutation[rand(0,4)] }}
                        <span class="text-green-600 cursor-default">{{ auth()->user()->name }}</span></p>
                    <p class="text-xs font-semibold"
                       x-text="currentTime"
                    ></p>
                </div>
            </div>
            <div class="px-2 lg:px-4 flex items-center space-x-2">

                <livewire:components.quick-customer/>
                <livewire:components.quick-order/>

                <div class="h-6 w-6 rounded-full border ring-2 ring-slate-100 dark:ring-slate-800 dark:border-slate-900 shadow-2xl flex items-center justify-center">
                    <button
                        x-on:click="theme = !theme"
                    >
                        <x-icons.moon x-show="theme"
                                      class="w-4 h-4 text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300"
                        />
                    </button>
                    <button
                        x-on:click="theme = !theme"
                    >
                        <x-icons.sun x-show="!theme"
                                     class="w-4 h-4 text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300"
                        />
                    </button>
                </div>

                <button
                    x-on:click="document.getElementById('logout-form').submit()"
                    class="link"
                >Sign out
                </button>

                <form action="{{ route('logout') }}"
                      method="POST"
                      class="hidden"
                      id="logout-form"
                >@csrf</form>
            </div>
        </header>


        <div class="px-2 lg:px-4 py-6 mt-16 relative">
            <x-notification/>
            {{ $slot }}
        </div>
    </main>


    @livewireScripts
</body>
</html>
