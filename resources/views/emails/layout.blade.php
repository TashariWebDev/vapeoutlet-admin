<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/email.css'])
</head>
<body class="bg-gray-900">
<div class="font-sans text-gray-900 antialiased bg-gray-900 w-full">
    <div class="bg-white p-2 rounded-md">
        <header class="flex justify-center items-center pb-4 border-b">
            <img src="{{ config('app.admin_url').'/logo.png' }}" alt="{{ config('app.name') }}"
                 class="w-20"
            >
        </header>
        <div class="py-4">
            @yield('content')
        </div>
        <footer class="flex justify-center items-center pt-6 border-t">
            <p class="text-gray-500 text-xs">&copy; {{  date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </footer>
    </div>
</div>
</body>
</html>
