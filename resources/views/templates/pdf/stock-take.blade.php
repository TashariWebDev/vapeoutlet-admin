<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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
<body class="relative">

<div class="font-sans w-screen bg-white antialiased overflow-hidden relative z-50">
    <div
        class="fixed font-extrabold transform rotate-45 text-gray-200 opacity-20 inset-0 min-h-screen min-w-screen z-10"
        style="font-size: 250px">
        <h1>STOCK TAKE</h1>
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
                        <li>{{ $model->date->format('d-m-Y') }}</li>
                        <li class="capitalize">STOCK TAKE ID:{{ $model->id }}</li>
                        <li class="uppercase font-extrabold text-lg">
                            {{ $model->processed_by }}
                            on {{ $model->processed_at }}</li>
                        <li class="uppercase font-extrabold text-lg">{{ number_format(to_rands($model->getTotal()),2) }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <div id="body" class="break-before-avoid-page">
            <div class="w-full grid grid-cols-5 break-inside-avoid">
                <div class="border text-left px-1 uppercase text-xs bg-gray-700 text-white">SKU/CODE</div>
                <div class="col-span-2 border text-left px-1 uppercase text-xs bg-gray-700 text-white">Item</div>
                <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Variance</div>
                <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Value</div>
            </div>

            <div class="break-before-avoid block">
                @foreach($model->items as $item)
                    <div class="w-full grid grid-cols-5 break-after-avoid-page py-1">
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

                        <div class="p-1 text-right">
                            <p class="font-extrabold text-gray-900">{{ $item->variance }}</p>
                        </div>

                        <div class="p-1 text-right">
                            <p class="font-extrabold text-gray-900">{{ number_format(to_rands($item->variance * $item->cost),2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
</body>
</html>
