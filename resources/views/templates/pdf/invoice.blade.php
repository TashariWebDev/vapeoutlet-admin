<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
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
<div class="font-sans w-screen bg-white antialiased p-6">
    <div class="p-4 bg-white rounded">
        <section id="header" class="pb-4">
            <div class="grid grid-cols-2 border-b">
                <div class="flex items-center space-x-6 w-full pb-2">
                    <div>
                        <img src="{{ config('app.url').'/logo.png' }}" class="w-16" alt="Vape Crew">
                    </div>
                    <div>
                        <ul>
                            <li class="font-bold text-sm">Vape Crew (PTY) LTD</li>
                            <li class="text-xs">4170276218 | 2012/037716/07</li>
                            <li class="text-xs">0836459599</li>
                            <li class="text-xs">sales@vapecrew.co.za</li>
                        </ul>
                    </div>
                </div>
                <div class="text-xs text-right font-mono">
                    <ul>
                        <li class="uppercase">{{ $model->placed_at ?? $model->created_at }}</li>
                        <li class="capitalize">{{ $model->number }}</li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 space-x-2 pt-2">
                <div class="border rounded">
                    <div class="bg-gray-700 px-1 rounded-t border border-gray-700">
                        <p class="text-white font-semibold uppercase text-xs">Customer Details</p>
                    </div>
                    <ul class="text-sm px-1 py-2">
                        <li>{{ ucwords($model->customer->name) }}</li>
                        <li>{{ $model->customer->phone }}</li>
                        <li>{{ $model->customer->email }}</li>
                        <li>{{ ucwords($model->customer->company) }}</li>
                        <li>{{ ucwords($model->customer->vat_number) }}</li>
                    </ul>
                </div>
                <div class="border rounded">
                    <div class="bg-gray-700 px-1 rounded-t border border-gray-700">
                        <p class="text-white font-semibold uppercase text-xs">Delivery Details</p>
                    </div>
                    <ul class="text-sm px-1 py-2">
                        <li>{{ ucwords($model->address->line_one) }}</li>
                        <li>{{ ucwords($model->address->line_two) }}</li>
                        <li>{{ ucwords($model->address->suburb) }}</li>
                        <li>{{ ucwords($model->address->city) }}</li>
                        <li>{{ ucwords($model->address->postal_code) }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <div id="body">

            <table class="w-full">
                <thead class="bg-gray-900 text-white text-sm uppercase font-bold">
                <tr>
                    <th class="text-left">SKU/CODE</th>
                    <th class="col-span-2 text-left">Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($model->items as $item)
                    <tr class="border-b border-dashed py-1 break-inside-avoid">
                        <td class="text-left">
                            <p class="font-semibold text-xs uppercase">{{ $item->product->sku }}</p>
                        </td>
                        <td class="col-span-2 text-left">
                            <p class="text-xs font-bold">
                                {{ ucwords($item->product->brand) }} {{ ucwords($item->product->name) }}
                            </p>
                            <span class="flex flex-wrap text-xs">
                            @foreach($item->product->features as $feature)
                                    <span class="text-xs font-thin pr-1">{{ ucwords($feature->name) }}</span>
                                @endforeach
                        </span>
                        </td>
                        <td class="text-right">
                            <p class="text-xs font-mono">{{ $item->qty }}</p>
                        </td>
                        <td class="text-right">
                            <p class="text-xs font-mono">
                                R {{ number_format($item->price,2) }}
                            </p>
                        </td>
                        <td class="text-right">
                            <p class="text-xs font-mono">
                                R {{ number_format($item->line_total,2) }}
                            </p>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="block break-before-avoid-page break-inside-avoid py-3 border-t mt-8 border-b border-gray-500">
                <div class="grid grid-cols-4 gap-2 break-after-avoid-page">
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">Sub Total </span> R {{ number_format($model->getSubTotal(),2) }}
                    </p>
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">{{ ucwords($model->delivery->type) }} </span>
                        R {{ number_format($model->delivery_charge,2) }}
                    </p>
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">Total </span>
                        R {{ number_format($model->getTotal(),2) }}
                    </p>
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">VAT </span>
                        R {{ number_format(vat($model->getTotal()),2) }}
                    </p>
                </div>

                <div class="block break-before-avoid-page py-3 mt-6 border-t border-b border-gray-500">
                    <div class="grid grid-cols-1 gap-2">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">ACCOUNT BALANCE </span>
                            R {{ number_format($model->customer->getRunningBalance(),2) }}
                        </p>
                    </div>
                </div>
            </div>
            <section id="footer" class="mt-6 border-t pt-2 break-before-avoid-page break-inside-avoid-page">
                <div class="bg-gray-700 text-center py-1 rounded">
                    <p class="text-white text-xs uppercase">
                        thank you for your support </p>
                </div>
                <div class="grid grid-cols-3 pt-2 break-before-avoid-page break-inside-avoid-page">
                    <div class="border rounded">
                        <div class="bg-gray-700 px-1 rounded-t border border-gray-700">
                            <p class="text-white font-semibold uppercase text-xs">Banking Details</p>
                        </div>
                        <ul class="text-xs p-1">
                            <li class="font-semibold">Vape Crew (PTY) LTD</li>
                            <li class="font-semibold">First National Bank</li>
                            <li class="font-semibold">Sandton City</li>
                            <li class="font-mono mt-2">ACC: 62668652855</li>
                            <li class="font-mono ">REF: {{ $model->number }}</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        @if($model->notes->count())
            <div class="mt-4 bg-white rounded-md p-4">

                @foreach($model->notes as $note)
                    <div class="pb-2">
                        <div>
                            @if($note->customer_id)
                                <p class="text-xs text-gray-400 uppercase">{{ $note->customer?->name }}
                                    on {{ $note->created_at }}</p>
                            @else
                                <p class="text-xs text-gray-400 uppercase">{{ $note->user?->name }}
                                    on {{ $note->created_at }}</p>
                            @endif
                        </div>
                        <div class="p-1">
                            <p class="capitalize text-sm">{{ $note->body }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
</div>
</body>
</html>
