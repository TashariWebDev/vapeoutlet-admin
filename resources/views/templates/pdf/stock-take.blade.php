<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ ucwords(str_replace('Admin','',config('app.name'))) }} Stock Take</title>

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
        <div
            class="fixed inset-0 z-10 min-h-screen font-extrabold text-gray-200 opacity-20 transform rotate-45 min-w-screen"
            style="font-size: 250px"
        >
            <h1>STOCK TAKE</h1>
        </div>
        <div class="flex z-50 flex-col p-6 min-h-screen bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2 border-b">
                    <x-document.company />
                    <div class="font-mono text-xs text-right">
                        <ul>
                            <li>{{ $stockTake->created_at }}</li>
                            <li class="capitalize">STOCK TAKE ID:{{ $stockTake->id }}</li>
                            <li class="capitalize">{{ $stockTake->sales_channel->name }}</li>

                            <li class="text-lg font-extrabold uppercase">
                                {{ $stockTake->processed_by }}
                                on {{ $stockTake->processed_at }}</li>
                            <li class="text-lg font-extrabold uppercase">
                                {{ number_format(to_rands($stockTake->getTotal()), 2) }}</li>
                            <li class="text-lg font-extrabold uppercase">
                                {{ $stockTake->getCount() }} Units
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <div
                class="break-before-avoid-page"
                id="body"
            >
                <div class="grid grid-cols-4 w-full break-inside-avoid">
                    <div class="px-1 text-xs text-left text-white uppercase bg-gray-700 border">SKU/CODE</div>
                    <div class="col-span-2 px-1 text-xs text-left text-white uppercase bg-gray-700 border">Item</div>
                    <div class="px-1 text-xs text-right text-white uppercase bg-gray-700 border">Variance</div>
                </div>

                <div class="block break-before-avoid">
                    @foreach ($stockTake->items as $item)
                        <div class="grid grid-cols-4 py-1 w-full break-after-avoid-page">
                            <div class="p-1">
                                <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                            </div>

                            <div class="col-span-2 p-1">
                                <p class="text-xs font-bold">
                                    {{ ucwords($item->product->brand) }}{{ ucwords($item->product->name) }}
                                </p>
                                <span class="flex flex-wrap">
                                    @foreach ($item->product->features as $feature)
                                        <span class="pr-1 text-xs font-thin">{{ ucwords($feature->name) }}</span>
                                    @endforeach
                                </span>
                            </div>

                            <div class="p-1 text-right">
                                <p class="font-extrabold text-gray-900">{{ $item->variance }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</body>

</html>
