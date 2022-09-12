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
                size: a4 landscape;
            }

            @page :first {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 landscape;
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
            <table class="w-full">
                <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="text-left">Date</th>
                    <th class="text-left">Customer</th>
                    <th class="text-right">Excl</th>
                    <th class="text-right">Vat</th>
                    <th class="text-right">Incl</th>
                </tr>
                </thead>
                <tbody class="text-sm">
                @foreach($credits as $grouped)
                    @foreach($grouped as $credit)
                        @if($loop->first)
                            <tr class="bg-gray-200 font-bold">
                                <td colspan="6" class="text-left">{{$credit->created_by}}</td>
                            </tr>
                        @endif
                        <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                            <td class="text-left">{{$credit->created_at}}</td>
                            <td class="text-left">{{$credit->customer->name}}</td>
                            <td class="text-right">{{  number_format(ex_vat($credit->getTotal()),2) }}</td>
                            <td class="text-right">{{  number_format(vat($credit->getTotal()),2) }}</td>
                            <td class="text-right">{{  number_format($credit->getTotal(),2) }}</td>
                        </tr>
                        @if($loop->last)
                            @php

                                $collectAllTotals = [];

                                foreach ($grouped as $credit){
                                    $collectAllTotals[] = $credit->getTotal();
                                }
                                $totalAmount = array_sum($collectAllTotals)

                            @endphp
                            <tr class="break-before-avoid-page break-inside-avoid-page">
                                <td colspan="2"></td>
                                <td class="text-right bg-gray-800 text-white">
                                    {{ number_format(ex_vat($totalAmount),2) }}
                                </td>
                                <td class="text-right bg-gray-800 text-white">
                                    {{ number_format(vat($totalAmount),2) }}
                                </td>
                                <td class="text-right bg-gray-800 text-white">
                                    {{ number_format($totalAmount,2) }}
                                </td>
                            </tr>
                            <tr class="text-white">
                                <td colspan="6" class="py-2"></td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
