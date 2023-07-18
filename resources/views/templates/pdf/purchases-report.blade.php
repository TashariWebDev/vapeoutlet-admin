<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ ucwords(str_replace('admin','',config('app.name'))) }} Purchases Report - {{ $fromDate }}
                                                                     - {{ $toDate }}</title>

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
    <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">

        <div class="break-inside-avoid break-after-avoid-page">
            <div class="px-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-white bg-gray-800">
                            <th class="text-left">Date</th>
                            <th class="text-left">Invoice No</th>
                            <th class="text-right">Excl</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Incl</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @php
                            $overallTotal = [];
                        @endphp
                        @foreach ($purchases as $grouped)
                            @foreach ($grouped as $purchase)
                                @if ($loop->first)
                                    <tr class="font-bold bg-gray-200">
                                        <td
                                            class="text-left"
                                            colspan="6"
                                        >{{ $purchase->supplier->name }}</td>
                                    </tr>
                                @endif
                                @php
                                    if ($purchase->exchange_rate > 0) {
                                        $amount = $purchase->total_cost_in_zar();
                                    } else {
                                        $amount = $purchase->amount;
                                    }
                                @endphp
                                <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                    <td class="text-left">{{ $purchase->date->format('d-m-y') }}</td>
                                    <td class="text-left">{{ $purchase->invoice_no }}</td>
                                    @if ($purchase->taxable)
                                        <td class="text-right">{{ number_format(ex_vat($amount), 2) }}</td>
                                    @else
                                        <td class="text-right">{{ number_format($amount, 2) }}</td>
                                    @endif
                                    @if ($purchase->taxable)
                                        <td class="text-right">{{ number_format(vat($amount), 2) }}</td>
                                    @else
                                        <td class="text-right">{{ number_format(to_rands(0), 2) }}</td>
                                    @endif
                                    <td class="text-right">
                                        {{ number_format($amount, 2) }}
                                    </td>
                                </tr>

                                @if ($loop->last)
                                    @php

                                        $amountsConvertedToRands = [];

                                        if ($purchase->exchange_rate > 0) {
                                            foreach ($grouped as $purchase) {
                                                $amountsConvertedToRands[] = $purchase->total_cost_in_zar();
                                            }
                                            $totalAmount = array_sum($amountsConvertedToRands);
                                        } else {
                                            $totalAmount = $grouped->sum('amount');
                                        }

                                        $overallTotal[] = $totalAmount;

                                    @endphp

                                    {{-- subtotals per supplier--}}
                                    <tr class="break-before-avoid-page break-inside-avoid-page">
                                        <td colspan="2"></td>
                                        <td class="text-right text-white bg-gray-800">
                                            @if ($purchase->exchange_rate > 0)
                                                {{ number_format($totalAmount, 2) }}
                                            @else ($purchase->exchange_rate > 0)
                                                {{ number_format(ex_vat($totalAmount), 2) }}
                                            @endif
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format(vat($grouped->where('taxable', true)->sum('amount')), 2) }}
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format($totalAmount, 2) }}</td>
                                    </tr>

                                    <tr class="text-white">
                                        <td
                                            class="py-2"
                                            colspan="6"
                                        ></td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        <tr class="h-10 font-bold bg-white border-t-4 border-dashed">
                            <td
                                class="text-right"
                                colspan="6"
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
