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
                {{ date('d-m-y h:i:sa') }}
            </div>
            <div class="px-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-white bg-gray-800">
                            <th class="text-left">Product</th>
                            <th class="text-left">Qty</th>
                            <th class="text-left">Cost</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Excl</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @php
                            $total = [];
                        @endphp
                        @foreach ($products as $product)
                            @php
                                $total[] = $product->stocks_sum_qty * $product->cost;
                            @endphp
                            <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                <td class="text-left">
                                    <div class="flex items-center space-x-2">
                                        {{ $product->brand }} {{ $product->name }}
                                        @foreach ($product->features as $feature)
                                            <div>
                                                {{ $feature->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        {{ $product->sku }}
                                    </div>
                                </td>
                                <td class="text-left">{{ $product->stocks_sum_qty }}</td>
                                <td class="text-left">{{ $product->cost }}</td>
                                <td class="text-right">{{ number_format($product->stocks_sum_qty * $product->cost, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format(vat($product->stocks_sum_qty * $product->cost), 2) }}</td>
                                <td class="text-right">
                                    {{ number_format(ex_vat($product->stocks_sum_qty * $product->cost), 2) }}</td>
                            </tr>
                            @if ($loop->last)
                                <tr class="h-10 font-bold bg-white">
                                    <td
                                        class="text-right"
                                        colspan="3"
                                    >
                                    </td>
                                    <td
                                        class="text-right"
                                        colspan="1"
                                    >
                                        {{ number_format(array_sum($total), 2) }}
                                    </td>
                                    <td
                                        class="text-right"
                                        colspan="1"
                                    >
                                        {{ number_format(vat(array_sum($total)), 2) }}
                                    </td>
                                    <td
                                        class="text-right"
                                        colspan="1"
                                    >
                                        {{ number_format(ex_vat(array_sum($total)), 2) }}
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
