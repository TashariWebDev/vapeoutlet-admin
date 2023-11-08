<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ ucwords(str_replace('Admin','',config('app.name'))) }} {{ ucwords($type) }} Report | {{ $from }}
                                                                                          - {{ $to }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            height: 100%;
        }

        @media print {
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
    <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">

        <div class="break-inside-avoid break-after-avoid-page">
            <div class="px-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-white bg-gray-800">
                            <th class="text-left">Created Date</th>
                            <th class="text-left">Trans Date</th>
                            <th class="text-left">Customer</th>
                            <th
                                class="text-left"
                                colspan="2"
                            >Ref
                            </th>
                            <th class="text-right">Excl</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Incl</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @php
                            $overallTotal = [];
                        @endphp

                        @foreach ($transactions as $grouped)
                            @php
                                $collectAllTotals = [];
                            @endphp
                            @foreach ($grouped as $transaction)
                                @if ($loop->first)
                                    <tr class="font-bold bg-gray-200">
                                        <td
                                            class="text-left"
                                            colspan="8"
                                        >{{ $transaction->created_by }}</td>
                                    </tr>
                                @endif
                                <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                    <td class="text-left">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    <td class="text-left">{{ $transaction->date->format('Y-m-d') }}</td>
                                    <td class="text-left">{{ $transaction->customer->name }}</td>
                                    <td
                                        class="text-left"
                                        colspan="2"
                                    >{{ $transaction->reference }}</td>
                                    <td class="text-right">{{ number_format(ex_vat(0 - $transaction->amount), 2) }}</td>
                                    <td class="text-right">{{ number_format(vat(0 - $transaction->amount), 2) }}</td>
                                    <td class="text-right">{{ number_format(0 - $transaction->amount, 2) }}</td>
                                </tr>
                                @if ($loop->last)
                                    @php

                                        $collectAllTotals = [];

                                        foreach ($grouped as $transaction) {
                                            $collectAllTotals[] = 0 - $transaction->amount;
                                        }
                                        $totalAmount = array_sum($collectAllTotals);

                                        $overallTotal[] = $totalAmount;

                                    @endphp
                                    <tr class="break-before-avoid-page break-inside-avoid-page">
                                        <td colspan="5"></td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format(ex_vat($totalAmount), 2) }}
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format(vat($totalAmount), 2) }}
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format($totalAmount, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="text-white">
                                        <td
                                            class="py-2"
                                            colspan="8"
                                        ></td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        <tr class="h-10 font-bold bg-white border-t-4 border-dashed">
                            <td
                                class="text-right"
                                colspan="8"
                            >
                                {{ number_format(array_sum($overallTotal), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
