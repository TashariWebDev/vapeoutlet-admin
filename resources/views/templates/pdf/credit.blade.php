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
<body>
<div class="font-sans w-screen bg-white antialiased overflow-hidden">
    <div class="p-6 bg-white rounded min-h-screen flex flex-col">
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
                        <li class="uppercase">{{ $model->created_by }}</li>
                        <li>{{ $model->created_at->format('d-m-Y') }}</li>
                        <li class="capitalize">{{ $model->number }}</li>
                        <li class="capitalize">Credit Note</li>
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
            </div>
        </section>

        <div id="body" class="break-before-avoid-page">
            <div class="w-full grid grid-cols-6 break-inside-avoid">
                <div class="border text-left px-1 uppercase text-xs bg-gray-700 text-white">SKU/CODE</div>
                <div class="col-span-2 border text-left px-1 uppercase text-xs bg-gray-700 text-white">Item</div>
                <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Qty</div>
                <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Price</div>
                <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Amount</div>
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
                            <p class="text-right text-xs font-mono">{{ $item->qty }}</p>
                        </div>
                        <div class="p-1">
                            <p class="text-right text-xs font-mono">R - {{ number_format($item->price,2) }}</p>
                        </div>
                        <div class="p-1">
                            <p class="text-right text-xs font-mono">R - {{ number_format($item->line_total,2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="block break-before-avoid-page py-3 border-t border-b border-gray-500">
                <div class="grid grid-cols-3 gap-2">
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">Sub Total </span> R - {{ number_format($model->getSubTotal(),2) }}
                    </p>
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">Total </span>
                        R - {{ number_format($model->getTotal(),2) }}
                    </p>
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">VAT </span>
                        R - {{ number_format(vat($model->getTotal()),2) }}
                    </p>
                </div>
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
        <section id="footer" class="mt-6 border-t pt-2 break-before-avoid-page">
            <div class="bg-gray-700 text-center py-1 rounded">
                <p class="text-white text-xs uppercase">
                    thank you for your support </p>
            </div>
            <div class="grid grid-cols-3 pt-2">
                <div class="border rounded">
                    <div class="bg-gray-700 px-1 rounded-t border border-gray-700">
                        <p class="text-white font-semibold uppercase text-xs">Banking Details</p>
                    </div>
                    <ul class="text-xs p-1">
                        <li class="font-semibold">Vape Crew (PTY) LTD</li>
                        <li class="font-semibold">First national Bank</li>
                        <li class="font-semibold">Sandton City</li>
                        <li class="font-mono mt-2">ACC: 62668652855</li>
                        <li class="font-mono ">REF: {{ $model->number }}</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
