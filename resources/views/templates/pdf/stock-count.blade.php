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
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"
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

<body class="relative">

    <div class="overflow-hidden relative z-50 w-screen font-sans antialiased bg-white">
        <div class="flex z-50 flex-col p-6 min-h-screen bg-white rounded">
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
                            <li>{{ $stockTake->created_at }}</li>
                            <li class="capitalize">STOCK TAKE ID:{{ $stockTake->id }}</li>
                            <li class="capitalize">{{ $stockTake->sales_channel->name }}</li>
                            <li class="text-lg font-extrabold uppercase">{{ $stockTake->created_by }}</li>
                        </ul>
                    </div>
                    <div class="pt-6">
                        <p>COUNTED BY: ......................................................</p>
                    </div>
                </div>
            </section>

            <div
                class="break-before-avoid-page"
                id="body"
            >
                <div class="grid grid-cols-6 w-full break-inside-avoid">
                    <div class="px-1 text-xs text-left text-white uppercase bg-gray-700 border">SKU/CODE</div>
                    <div class="col-span-3 px-1 text-xs text-left text-white uppercase bg-gray-700 border">Item</div>
                    <div class="col-span-2 px-1 text-xs text-right text-white uppercase bg-gray-700 border">Count</div>
                </div>

                <div class="block break-before-avoid">
                    @foreach ($stockTake->items as $item)
                        <div class="grid grid-cols-6 py-1 w-full break-after-avoid-page">
                            <div class="p-1">
                                <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                            </div>
                            <div class="col-span-3 p-1">
                                <p class="text-xs font-bold">
                                    {{ ucwords($item->product->brand) }}{{ ucwords($item->product->name) }}
                                </p>
                                <span class="flex flex-wrap">
                                    @foreach ($item->product->features as $feature)
                                        <span class="pr-1 text-xs font-thin">{{ ucwords($feature->name) }}</span>
                                    @endforeach
                                </span>
                            </div>
                            <div class="flex col-span-2 justify-end items-center p-1">
                                <div class="flex justify-center items-center w-12 h-12 text-lg rounded-md border">
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
