<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Invoice</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {

            /*section,*/
            /*td,*/
            /*tr,*/
            /*div,*/
            section {
                page-break-inside: avoid !important;
            }

            @page {
                margin-top: 3mm;
                margin-bottom: 0;
                size: legal portrait;
            }

            @page :first {
                margin-top: 3mm;
                margin-bottom: 0;
                size: legal portrait;
            }
        }
    </style>
</head>

<body>
    <div class="w-screen font-sans antialiased bg-white">
        <div
            class="fixed inset-0 z-10 min-h-screen font-extrabold text-gray-200 opacity-20 transform rotate-45 min-w-screen"
            style="font-size: 250px"
        >
            <h1>DELIVERY NOTE</h1>
        </div>
        <div class="p-6 bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2 border-b">
                    <div class="flex items-center pb-2 space-x-6 w-full">
                        <div>
                            <img
                                class="w-16"
                                src="{{ config('app.url') . '/logo.png' }}"
                                alt="Vape Crew"
                            >
                        </div>
                        <div>
                            <ul>
                                <li class="text-sm font-bold">Vape Crew (PTY) LTD</li>
                                <li class="text-xs">4170276218 | 2012/037716/07</li>
                                <li class="text-xs">0836459599</li>
                                <li class="text-xs">sales@vapecrew.co.za</li>
                            </ul>
                        </div>
                    </div>
                    <div class="font-mono text-xs text-right">
                        <ul>
                            <li>{{ $order->placed_at ?? $order->created_at }}</li>
                            <li class="capitalize">{{ $order->number }}</li>
                            <li class="text-lg font-extrabold uppercase">{{ $order->delivery->type }}</li>
                        </ul>
                    </div>
                    <div class="pt-6">
                        <p>CHECKED BY: ......................................................</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($order->customer->name) }}</li>
                            <li>{{ $order->customer->phone }}</li>
                            <li>{{ $order->customer->email }}</li>
                            <li>{{ ucwords($order->customer->company) }}</li>
                            <li>{{ ucwords($order->customer->vat_number) }}</li>
                        </ul>
                    </div>
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Order Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($order->address->line_one) }}</li>
                            <li>{{ ucwords($order->address->line_two) }}</li>
                            <li>{{ ucwords($order->address->suburb) }}</li>
                            <li>{{ ucwords($order->address->city) }}</li>
                            <li>{{ ucwords($order->address->postal_code) }}</li>
                        </ul>
                    </div>
                </div>
            </section>

            <div id="body">

                <table class="w-full">
                    <thead class="text-sm font-bold text-white uppercase bg-gray-900">
                        <tr>
                            <th class="text-left">SKU/CODE</th>
                            <th class="col-span-2 text-left">Item</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b border-dashed">
                                <td class="text-left">
                                    <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                                </td>
                                <td class="col-span-2 text-left">
                                    <p class="text-xs font-bold">
                                        {{ ucwords($item->product->brand) }} {{ ucwords($item->product->name) }}
                                    </p>
                                    <span class="flex flex-wrap text-xs">
                                        @foreach ($item->product->features as $feature)
                                            <span class="pr-1 text-xs font-thin">{{ ucwords($feature->name) }}</span>
                                        @endforeach
                                    </span>
                                </td>
                                <td class="text-right">
                                    <p class="font-mono text-xs">{{ $item->qty }}</p>
                                </td>
                                <td class="flex justify-end py-1 text-right">
                                    <div
                                        class="flex justify-center items-center p-1 w-6 h-6 font-bold text-gray-100 border">
                                        X
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 mt-4 bg-white rounded-md">

                @foreach ($order->notes as $note)
                    <div class="pb-2">
                        <div>
                            @if ($note->customer_id)
                                <p class="text-xs text-gray-400 uppercase">{{ $note->customer?->name }}
                                    on {{ $note->created_at }}</p>
                            @else
                                <p class="text-xs text-gray-400 uppercase">{{ $note->user?->name }}
                                    on {{ $note->created_at }}</p>
                            @endif
                        </div>
                        <div class="p-1">
                            <p class="text-sm capitalize">{{ $note->body }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</body>

</html>
