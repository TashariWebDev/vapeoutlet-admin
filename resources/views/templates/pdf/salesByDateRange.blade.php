<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >
    <title></title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
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
                            <th class="text-left">Invoice No</th>
                            <th class="text-left">Status</th>
                            <th class="text-right">Incl</th>
                            <th class="text-right">Vat</th>
                            <th class="text-right">Excl</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($customers as $customerCollection)
                            @foreach($customerCollection as $customer)
                                @php
                                    $total = []
                                @endphp
                                @if($loop->first)
                                    <tr aria-rowspan="2"
                                        class="bg-gray-900 text-white row-span-2 font-bold"
                                    >
                                        <td colspan="6"
                                            class="text-left"
                                        >{{$customer->salesperson?->name ?? 'unalocated'}}</td>
                                    </tr>
                                @endif

                                @foreach($customer->orders as $order)
                                    @php
                                        $total[] = $order->sub_total
                                    @endphp
                                    @if($loop->first)
                                        <tr class="bg-gray-100 font-bold">
                                            <td colspan="6"
                                                class="text-left"
                                            >{{$customer->name}}</td>
                                        </tr>
                                    @endif
                                    <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                                        <td class="text-left">{{$order->created_at->format('Y-m-d')}}</td>
                                        <td class="text-left">{{$order->id}}</td>
                                        <td class="text-left">{{$order->status}}</td>
                                        <td class="text-right">{{  number_format($order->sub_total,2) }}</td>
                                        <td class="text-right">{{  number_format(vat($order->sub_total),2) }}</td>
                                        <td class="text-right">{{  number_format(ex_vat($order->sub_total),2) }}</td>
                                    </tr>
                                    @if($loop->last)
                                        <tr class="bg-white font-bold h-10">
                                            <td colspan="6"
                                                class="text-right"
                                            >
                                                {{ number_format(ex_vat(array_sum($total)),2) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
