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

    <style>
        body {
            height: 100%;
        }

        @media print {
            section {
                page-break-inside: avoid;
            }

            aside {
                min-height: 100vh;
            }
        }

        @page :first {
            margin-top: 5cm;
            margin-bottom: 5cm;
            margin-left: 5cm;
            margin-right: 5cm;
        }

        @page {
            margin-top: 5cm;
            margin-bottom: 5cm;
            margin-left: 5cm;
            margin-right: 5cm;
            height: 100%;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="w-full min-h-screen text-sm bg-pink-700 md:text-base">
        @yield('content')
    </div>

</body>

</html>
