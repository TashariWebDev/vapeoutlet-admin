<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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


            @page :first {
                margin-top: 0;
                margin-right: 5mm;
                margin-left: 5mm;
                margin-bottom: 25mm;
                size: letter portrait;
            }

        }

    </style>
</head>
<body class="relative">

<div class="font-sans w-screen bg-white antialiased overflow-hidden relative z-50">
    <div
        class="fixed font-extrabold transform rotate-45 text-gray-200 opacity-20 inset-0 min-h-screen min-w-screen z-10"
        style="font-size: 250px">
        <h1>DELIVERY NOTE</h1>
    </div>
    <div class="p-6 bg-white rounded min-h-screen flex flex-col z-50">
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

        <div id="body" class="break-before-avoid-page">
            <div class="w-full grid grid-cols-6 break-inside-avoid">
                <div class="border text-left px-1 uppercase text-xs bg-gray-700 text-white">SKU/CODE</div>
                <div class="col-span-2 border text-left px-1 uppercase text-xs bg-gray-700 text-white">Item</div>
                <div class="border px-1 text-center uppercase text-xs bg-gray-700 text-white">Qty</div>
                <div class="col-span-2 border px-1 text-right uppercase text-xs bg-gray-700 text-white">Count</div>
            </div>

            <div class="break-before-avoid block">
                @foreach($model->items as $item)
                    <div class="w-full grid grid-cols-6 break-after-avoid-page py-1">
                        <div class="p-1">
                            <p class="font-semibold text-xs uppercase">{{ $item->product->sku }}</p>
                        </div>
                        <div class="col-span-2 p-1">
                            <p class="text-xs font-bold">
                                {{ ucwords($item->product->brand) }}{{ ucwords($item->product->name) }}
                            </p>
                            <span class="flex flex-wrap">
                                    @foreach($item->product->features as $feature)
                                    <span class="text-xs font-thin pr-1">{{ ucwords($feature->name) }}</span>
                                @endforeach
                                </span>
                        </div>
                        <div class=" p-1">
                            <p class="text-center text-2xl font-extrabold font-mono">{{ $item->qty }}</p>
                        </div>
                        <div class="p-1 col-span-2 flex justify-end items-center">
                            <div class="w-12 h-12 text-lg border rounded-md flex justify-center items-center">
                                <p class="font-extrabold text-gray-100">X</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
</body>
</html>
