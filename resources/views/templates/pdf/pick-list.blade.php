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
<div class="font-sans w-screen bg-white antialiased">
    <div
        class="fixed font-extrabold transform rotate-45 text-gray-200 opacity-20 inset-0 min-h-screen min-w-screen z-10"
        style="font-size: 250px">
        <h1>PICKING SLIP</h1>
    </div>
    <div class="p-6 bg-white rounded">
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
                        <li>{{ $model->created_at->format('d-m-Y') }}</li>
                        <li class="capitalize">{{ $model->number }}</li>
                        <li class="uppercase font-extrabold text-lg">{{ $model->delivery->type }}</li>
                    </ul>
                </div>
                <div class="pt-6">
                    <p>CHECKED BY: ......................................................</p>
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
                        <p class="text-white font-semibold uppercase text-xs">Order Details</p>
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
                    <th class="text-right">Count</th>
                </tr>
                </thead>
                <tbody>
                @foreach($model->items as $item)
                    <tr class="border-b border-dashed">
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
                        <td class="text-right flex justify-end py-1">
                            <div class="w-6 h-6 border flex justify-center items-center text-gray-100 font-bold p-1">
                                X
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

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
    </div>
</div>
</body>
</html>
