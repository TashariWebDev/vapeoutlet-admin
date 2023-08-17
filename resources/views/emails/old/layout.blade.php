<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/email.css'])
</head>

<body class="p-4 bg-gray-900">
    <div class="w-full h-full font-sans antialiased text-gray-900 bg-gray-900">
        <div class="p-2 bg-white rounded-md">
            <header class="flex justify-center items-center pb-4 border-b">
                <img
                    class="w-20"
                    src="{{ config('app.frontend_url') . '/logo.png' }}"
                    alt="{{ config('app.name') }}"
                >
            </header>
            <div class="py-4">
                @yield('content')
            </div>
            <footer class="flex justify-center items-center pt-6 border-t">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}. All
                                                 rights reserved.</p>
            </footer>
        </div>
    </div>
</body>

</html>
