<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            height: 100%;
        }


        @media print {
            /*section,*/
            /*td,*/
            /*tr,*/
            /*div,*/
            section {
                page-break-inside: avoid;
            }


            @page {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 portrait;
            }

            @page :first {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 portrait;
            }

        }

    </style>
</head>
<body>
<div class="font-sans w-screen bg-white antialiased overflow-hidden p-4">


    <div class="break-inside-avoid break-after-avoid-page">
        <div class="px-4">
            {{ date("Y-m-d h:i:sa") }}
        </div>
        <div class="px-4">
            @foreach($customers as $customer)
                @if($customer->getRunningBalance() != 0)
                    <div class="flex justify-between items-center border-b border-dashed pb-1">
                        <div class="break-inside-avoid">
                            <p class="text-sm font-medium text-gray-900 uppercase">
                                {{ $customer->name }} {{ $customer->company }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">
                                R {{ number_format($customer->getRunningBalance(),2) }}
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
