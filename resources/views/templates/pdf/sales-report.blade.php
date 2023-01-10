<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Sales Report | {{ $from }} - {{ $to }}</title>

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
                            <th class="text-left">Status</th>
                            <th class="text-right">Incl</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Excl</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @php
                            $overallTotal = [];
                        @endphp
                        @foreach ($customers as $customerCollection)
                            @php
                                $grandTotal = [];
                            @endphp
                            @foreach ($customerCollection as $customer)
                                @php
                                    $total = [];
                                @endphp
                                @if ($loop->first)
                                    <tr
                                        class="row-span-2 font-bold text-white bg-gray-900"
                                        aria-rowspan="2"
                                    >
                                        <td
                                            class="text-left"
                                            colspan="6"
                                        >{{ $customer->salesperson?->name ?? 'unalocated' }}</td>
                                    </tr>
                                @endif
                                @foreach ($customer->orders as $order)
                                    @php
                                        $total[] = $order->sub_total;
                                    @endphp
                                    @if ($loop->first)
                                        <tr class="font-bold bg-gray-100">
                                            <td
                                                class="text-left"
                                                colspan="6"
                                            >{{ $customer->name }}</td>
                                        </tr>
                                    @endif
                                    <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                        <td class="text-left">{{ $order->created_at->format('d-m-y') }}</td>
                                        <td class="text-left">{{ $order->id }}</td>
                                        <td class="text-left">{{ $order->status }}</td>
                                        <td class="text-right">{{ number_format($order->sub_total, 2) }}</td>
                                        <td class="text-right">{{ number_format(vat($order->sub_total), 2) }}</td>
                                        <td class="text-right">{{ number_format(ex_vat($order->sub_total), 2) }}</td>
                                    </tr>
                                    @if ($loop->last)
                                        <tr class="h-10 font-bold bg-white">
                                            <td
                                                class="text-right"
                                                colspan="6"
                                            >
                                                {{ number_format(ex_vat(array_sum($total)), 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @php
                                    $grandTotal[] = array_sum($total);
                                    $overallTotal[] = array_sum($total);
                                @endphp
                                @if ($loop->last)
                                    <tr class="h-10 font-bold bg-white">
                                        <td
                                            class="text-right"
                                            colspan="6"
                                        >
                                            {{ number_format(ex_vat(array_sum($grandTotal)), 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        <tr class="h-10 font-bold bg-white border-t-4 border-dashed">
                            <td
                                class="text-right"
                                colspan="6"
                            >
                                {{ number_format(ex_vat(array_sum($overallTotal)), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
