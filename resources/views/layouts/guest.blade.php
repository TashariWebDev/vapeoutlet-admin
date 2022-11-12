<!DOCTYPE html>
<html
    class="dark"
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

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="font-sans antialiased text-slate-400">
        {{ $slot }}
    </div>
</body>

</html>
