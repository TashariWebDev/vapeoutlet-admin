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
    <link rel="icon"
          type="image/png"
          sizes="196x196"
          href="{{ config('app.frontend_url').'/favicon-196.png' ?? asset('favicon-196.png') }}"
    >
    <meta name="msapplication-square70x70logo"
          content="{{ config('app.frontend_url').'/mstile-icon-128.png' ?? asset('mstile-icon-128.png') }}"
    >
    <meta name="msapplication-square150x150logo"
          content="{{ config('app.frontend_url').'/mstile-icon-270.png' ?? asset('mstile-icon-270.png') }}"
    >
    <meta name="msapplication-square310x310logo"
          content="{{ config('app.frontend_url').'/mstile-icon-558.png' ?? asset('mstile-icon-558.png') }}"
    >
    <meta name="msapplication-wide310x150logo"
          content="{{ config('app.frontend_url').'/mstile-icon-558-270.png' ?? asset('mstile-icon-558-270.png') }}"
    >
    <link rel="apple-touch-icon"
          href="{{ config('app.frontend_url').'/apple-icon-180.png' ?? asset('apple-icon-180.png') }}"
    >
    
    <meta name="apple-mobile-web-app-capable"
          content="yes"
    >
    <meta name="mobile-web-app-capable"
          content="yes"
    >
    <meta name="apple-touch-fullscreen"
          content="yes"
    />
    <meta name="apple-mobile-web-app-title"
          content="Vape Outlet"
    />
    <meta name="apple-mobile-web-app-status-bar-style"
          content="black-translucent"
    />
    
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2048-2732.jpg' ?? asset('apple-splash-2048-2732.jpg') }}"
          media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2732-2048.jpg' ?? asset('apple-splash-2732-2048.jpg') }}"
          media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link
        rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ config('app.frontend_url').'/apple-splash-2388-1668.jpg' ?? asset('apple-splash-2388-1668.jpg') }}"
    />
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1668-2388.jpg' ?? asset('apple-splash-1668-2388.jpg') }}"
          media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2388-1668.jpg' ?? asset('apple-splash-2388-1668.jpg') }}"
          media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1536-2048.jpg' ?? asset('apple-splash-1536-2048.jpg') }}"
          media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2048-1536.jpg' ?? asset('apple-splash-2048-1536.jpg') }}"
          media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1668-2224.jpg' ?? asset('apple-splash-1668-2224.jpg') }}"
          media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2224-1668.jpg' ?? asset('apple-splash-2224-1668.jpg') }}"
          media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1620-2160.jpg' ?? asset('apple-splash-1620-2160.jpg') }}"
          media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2160-1620.jpg' ?? asset('apple-splash-2160-1620.jpg') }}"
          media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2160-1620.jpg' ?? asset('apple-splash-2160-1620.jpg') }}"
          media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1284-2778.jpg' ?? asset('apple-splash-1284-2778.jpg') }}"
          media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2778-1284.jpg' ?? asset('apple-splash-2778-1284.jpg') }}"
          media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1170-2532.jpg' ?? asset('apple-splash-1170-2532.jpg') }}"
          media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2532-1170.jpg' ?? asset('apple-splash-2532-1170.jpg') }}"
          media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1125-2436.jpg' ?? asset('apple-splash-1125-2436.jpg') }}"
          media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1125-2436.jpg' ?? asset('apple-splash-1125-2436.jpg') }}"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2436-1125.jpg' ?? asset('apple-splash-2436-1125.jpg') }}"
          media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1242-2688.jpg' ?? asset('apple-splash-1242-2688.jpg') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2688-1242.jpg' ?? asset('apple-splash-2688-1242.jpg') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-828-1792.jpg' ?? asset('apple-splash-828-1792.jpg') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1792-828.jpg' ?? asset('apple-splash-1792-828.jpg') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1242-2208.jpg' ?? asset('apple-splash-1242-2208.jpg') }}"
          media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-2208-1242.jpg' ?? asset('apple-splash-2208-1242.jpg') }}"
          media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-750-1334.jpg' ?? asset('apple-splash-750-1334.jpg') }}"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1334-750.jpg' ?? asset('apple-splash-1334-750.jpg') }}"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-640-1136.jpg' ?? asset('apple-splash-640-1136.jpg') }}"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    >
    <link rel="apple-touch-startup-image"
          href="{{ config('app.frontend_url').'/apple-splash-1136-640.jpg' ?? asset('apple-splash-1136-640.jpg') }}"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
    >
    <link rel="manifest"
          href="{{  asset('manifest.json') }}"
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
            class="sticky top-0 z-40 w-full border-t-4 dark:bg-transparent border-sky-400 bg-white/60 backdrop-blur dark:border-sky-500"
        >
            <div class="flex justify-between items-center py-1 px-6 mx-auto md:px-8 text-slate-500 max-w-8xl dark:text-slate-300">
                <p class="text-xs font-bold">{{ $salutation[rand(0, 4)] }}
                    <span>
                        {{ auth()->user()->name }}
                    </span>
                </p>
                <div>
                    <p
                        class="text-xs font-semibold"
                        x-text="currentTime"
                    ></p>
                </div>
            </div>
            <div class="px-4 mx-auto sm:px-6 md:px-8 max-w-8xl">
                <div class="flex justify-center items-center w-full lg:justify-between">
                    <div class="flex items-center py-2 lg:justify-between lg:py-1">
                        <div class="hidden lg:block text-slate-500 dark:text-slate-500">
                            <livewire:users.default-sales-channel />
                        </div>
                        <container
                            class="hidden items-center px-4 mx-auto space-x-6 lg:flex lg:py-2 lg:pb-1 lg:max-w-7xl"
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
                    <div class="flex items-center py-2 space-x-4 lg:py-1">
                        @if (auth()->user()->sales_channels_count > 1)
                            <div>
                                <livewire:users.sales-channel-change-button />
                            </div>
                        @endif
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
                            class="flex justify-center items-center w-6 h-6 rounded-full border ring-2 border-sky-400 ring-slate-100 dark:ring-slate-800"
                        >
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
                    class="flex overflow-x-scroll items-center py-4 px-4 mx-auto space-x-6 border-t lg:hidden lg:py-2 lg:pb-1 lg:max-w-7xl border-sky-400/50"
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
