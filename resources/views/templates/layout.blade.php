<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


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
            margin-top: 5;
            margin-bottom: 5;
            margin-left: 5;
            margin-right: 5;
        }

        @page {
            margin-top: 5;
            margin-bottom: 5;
            margin-left: 5;
            margin-right: 5;
            height: 100;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="text-sm md:text-base min-h-screen w-full bg-red-700"
>
    @yield('content')
</div>

</body>
</html>
