<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title class="capitalize">
        {{ ucwords(str_replace('Admin','',config('app.name'))) }} Stock Variances Report | {{ $from }}
                                                                  - {{ $to }}
    </title>

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
                <table class="w-full">
                    <thead>
                        <tr class="text-xs font-semibold text-white uppercase bg-gray-900">
                            <th class="text-left">Product</th>
                            <th class="text-center">Reference</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Ex Vat</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            @if ($stock->qty != 0)
                                <tr class="text-xs">
                                    <td class="text-left">
                                        <div class="break-inside-avoid">
                                            <p class="text-xs font-bold">
                                                {{ ucwords($stock->product->brand) }}
                                                {{ ucwords($stock->product->name) }}
                                            </p>
                                            <span class="flex flex-wrap text-xs">
                                                @foreach ($stock->product->features as $feature)
                                                    <span
                                                        class="pr-1 text-xs font-thin"
                                                    >{{ ucwords($feature->name) }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $stock->reference }}</td>
                                    <td class="text-center">{{ $stock->qty }}</td>
                                    <td class="text-right">{{ number_format($stock->cost, 2) }}</td>
                                    <td class="text-right">{{ number_format(ex_vat($stock->getTotal()), 2) }}</td>
                                    <td class="text-right">{{ number_format(vat($stock->getTotal()), 2) }}</td>
                                    <td class="text-right">{{ number_format($stock->getTotal(), 2) }}</td>
                                </tr>
                            @endif
                            @if ($loop->last)
                                @php
                                    $totals = [];

                                    foreach ($stocks as $stock) {
                                        $totals[] = $stock->getTotal();
                                    }

                                    $totalAmount = array_sum($totals);
                                @endphp
                                <tr class="text-xs break-inside-avoid">
                                    <td colspan="4"></td>
                                    <td class="text-right text-white bg-gray-900">
                                        {{ number_format(ex_vat($totalAmount), 2) }}
                                    </td>
                                    <td class="text-right text-white bg-gray-900">
                                        {{ number_format(vat($totalAmount), 2) }}
                                    </td>
                                    <td class="text-right text-white bg-gray-900">
                                        {{ number_format($totalAmount, 2) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
