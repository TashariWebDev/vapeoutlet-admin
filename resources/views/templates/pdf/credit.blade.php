<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Credit Note</title>
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
    <div class="p-6 w-screen font-sans antialiased bg-white">
        <div class="p-6 bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2 border-b">
                    <x-document.company />
                    <div class="font-mono text-xs text-right">
                        <ul>
                            <li class="uppercase">{{ $credit->created_at }}</li>
                            <li class="capitalize">{{ $credit->number }}</li>
                            <li class="capitalize">{{ $credit->sales_channel->name }}</li>
                            <li class="capitalize">Credit Note</li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($credit->customer->name ?: '') }}</li>
                            <li>{{ $credit->customer->phone }}</li>
                            <li>{{ $credit->customer->email }}</li>
                            <li>{{ ucwords($credit->customer->company ?: '') }}</li>
                            <li>{{ ucwords($credit->customer->vat_number ?: '') }}</li>
                        </ul>
                    </div>
                </div>
            </section>
            
            <div
                class="break-before-avoid-page"
                id="body"
            >
                <table class="w-full">
                    <thead class="text-sm font-bold text-white uppercase bg-gray-900">
                        <tr>
                            <th class="text-left">SKU/CODE</th>
                            <th class="col-span-2 text-left">Item</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($credit->items as $item)
                            <tr class="py-1 border-b border-dashed">
                                <td class="text-left">
                                    <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                                </td>
                                <td class="col-span-2 text-left">
                                    <p class="text-xs font-bold">
                                        {{ ucwords($item->product->brand ?: '') }}
                                        {{ ucwords($item->product->name ?: '') }}
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
                                <td class="text-right">
                                    <p class="font-mono text-xs">
                                        R {{ number_format($item->price, 2) }}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p class="font-mono text-xs">
                                        R {{ number_format($item->line_total, 2) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div
                    class="block py-3 mt-8 border-t border-b border-gray-500 break-before-avoid-page break-inside-avoid"
                >
                    <div class="grid grid-cols-4 gap-2 break-after-avoid-page">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">Sub Total </span>
                            R {{ number_format($credit->getSubTotal(), 2) }}
                        </p>
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">Delivery</span>
                            R {{ number_format($credit->delivery_charge, 2) }}
                        </p>
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">Total </span>
                            R {{ number_format($credit->getTotal(), 2) }}
                        </p>
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">VAT </span>
                            R {{ number_format(vat($credit->getTotal()), 2) }}
                        </p>
                    </div>
                </div>
                
                <div class="block py-3 mt-6 border-t border-b border-gray-500 break-before-avoid-page">
                    <div class="grid grid-cols-1 gap-2">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">ACCOUNT BALANCE </span>
                            R {{ number_format($credit->customer->getRunningBalance(), 2) }}
                        </p>
                    </div>
                </div>
            </div>
            <section
                class="overflow-visible pt-2 mt-6 border-t break-before-avoid-page break-inside-avoid-page"
                id="footer"
            >
                <div class="py-1 text-center bg-gray-700 rounded">
                    <p class="text-xs text-white uppercase">
                        thank you for your support </p>
                </div>
            </section>
        </div>
    </div>
</body>

</html>
