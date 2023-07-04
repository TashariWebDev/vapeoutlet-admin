<!DOCTYPE html>
<html
    class="dark"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <title>{{ config('app.name') }}</title>
    @include('layouts.meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="font-sans antialiased text-slate-400">
        {{ $slot }}
    </div>
</body>

</html>
