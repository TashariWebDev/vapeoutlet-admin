<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>
        Discount Report | {{ $from }} - {{ $to }}
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
                            <th class="text-left">Product</th>
                            <th class="text-right">Excl</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Incl</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">

                        @php
                            $overallTotal = [];
                        @endphp

                        @foreach ($discounts as $grouped)
                            @foreach ($grouped as $discount)
                                <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                    <td class="text-left">{{ $discount->created_at->format('d-m-y') }}</td>
                                    <td class="text-left">{{ $discount->order->number }}</td>
                                    <td class="text-left">
                                        <x-product-listing-simple :product="$discount->product" />
                                    </td>
                                    <td class="text-right">
                                        {{ number_format(ex_vat($discount->discount), 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format(vat($discount->discount), 2) }}
                                    </td>
                                    <td class="text-right">{{ number_format($discount->discount, 2) }}</td>
                                </tr>

                                @php
                                    $overallTotal[] = $discount->discount;
                                @endphp

                                @if ($loop->last)
                                    <tr class="break-before-avoid-page break-inside-avoid-page">
                                        <td colspan="3"></td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format($grouped->sum('discount') - vat($grouped->sum('discount')), 2) }}
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format(vat($grouped->sum('discount')), 2) }}
                                        </td>
                                        <td class="text-right text-white bg-gray-800">
                                            {{ number_format($grouped->sum('discount'), 2) }}</td>
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
                            @php
                                $sumOfTotal = array_sum($overallTotal);
                            @endphp
                            <td
                                class="text-right"
                                colspan="3"
                            >
                            </td>
                            <td
                                class="text-right"
                                colspan="1"
                            >
                                {{ number_format(ex_vat($sumOfTotal), 2) }}
                            </td>
                            <td
                                class="text-right"
                                colspan="1"
                            >
                                {{ number_format(vat($sumOfTotal), 2) }}
                            </td>
                            <td
                                class="text-right"
                                colspan="1"
                            >
                                {{ number_format($sumOfTotal, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
