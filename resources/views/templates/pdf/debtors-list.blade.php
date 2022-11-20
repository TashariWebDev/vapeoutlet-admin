<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title></title>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    >
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
    <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">

        <div class="break-inside-avoid break-after-avoid-page">
            <div class="px-4">
                {{ date('d-m-y h:i:sa') }}
            </div>
            <div class="px-4">
                @php
                    $overallTotal = [];
                @endphp
                @foreach ($customers as $customer)
                    @if ($customer->getRunningBalance() != 0)
                        <div class="flex justify-between items-center pb-1 border-b border-dashed">
                            <div class="break-inside-avoid">
                                <p class="text-sm font-medium text-gray-900 uppercase">
                                    {{ $customer->name }} {{ $customer->company }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    R {{ number_format($customer->getRunningBalance(), 2) }}
                                </p>
                            </div>
                        </div>
                        @php
                            $overallTotal[] = $customer->getRunningBalance();
                        @endphp
                    @endif
                @endforeach
                <div class="flex justify-end border-t-4 border-dashed">
                    <td
                        class="text-right"
                        colspan="6"
                    >
                        {{ number_format(array_sum($overallTotal), 2) }}
                    </td>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
