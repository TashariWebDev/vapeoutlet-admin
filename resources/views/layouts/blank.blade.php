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
          content="{{ config('app.name') }}"
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
          href="{{ config('app.frontend_url').'/manifest.json' ?? asset('manifest.json') }}"
    >

    <link rel="stylesheet"
          href="https://rsms.me/inter/inter.css"
    >

    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="flex relative min-h-full font-sans antialiased bg-slate-200 dark:bg-slate-950"

    x-cloak
    x-data="{
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
    x-init="
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


        <div class="relative py-10 px-4 lg:px-20 prose">
            {{ $slot }}
        </div>

    </main>

    @livewireScripts
</body>

</html>
