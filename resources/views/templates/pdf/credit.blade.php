@php use App\Models\SystemSetting; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title> Credit Note</title>
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
                size: a4 portrait;
            }

            @page :first {
                margin-top: 3mm;
                margin-bottom: 0;
                size: a4 portrait;
            }
        }
    </style>
</head>

<body>
    <div class="p-2 w-screen font-sans antialiased bg-white">
        <div class="p-6 bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2">
                    <x-document.company />
                    <div class="text-right text-[10px]">
                        <ul>

                            <li class="font-extrabold uppercase">Credit Note</li>
                            <li class="font-semibold leading-tight uppercase text-[10px]">{{ $credit->created_at }}</li>
                            <li class="font-semibold leading-tight uppercase text-[10px]">
                                <span class="font-medium leading-tight text-gray-500">
                                    {{ '( ' . $credit->sales_channel->name . ' )' }}
                                </span>
                                {{ $credit->number }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="border">
                        <div class="px-1 bg-gray-300">
                            <p class="font-bold uppercase text-[10px] text-slate-900">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1">
                            <li>
                                <p class="leading-tight text-[10px] text-slate-900">
                                    {{ ucwords($credit->customer->name) }}</p>
                            </li>
                            <li>
                                <p class="leading-tight text-[10px] text-slate-900">{{ $credit->customer->phone }}</p>
                            </li>
                            <li>
                                <p class="leading-tight text-[10px] text-slate-900">{{ $credit->customer->email }}</p>
                            </li>
                            <li>
                                <p class="leading-tight text-[10px] text-slate-900">
                                    {{ ucwords($credit->customer->company) }}</p>
                            </li>
                            <li>
                                <p class="leading-tight text-[10px] text-slate-900">
                                    {{ ucwords($credit->customer->vat_number) }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <div id="body">

                <table class="w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="font-bold leading-snug text-left uppercase text-[10px] text-slate-900">SKU/CODE
                            </th>
                            <th
                                class="col-span-2 font-bold leading-snug text-left uppercase text-[10px] text-slate-900"
                            >
                                Item
                            </th>
                            <th class="font-bold leading-snug text-right uppercase text-[10px] text-slate-900">Qty</th>
                            <th class="font-bold leading-snug text-right uppercase text-[10px] text-slate-900">Price
                            </th>
                            <th class="font-bold leading-snug text-right uppercase text-[10px] text-slate-900">
                                Discount
                            </th>
                            <th class="font-bold leading-snug text-right uppercase text-[10px] text-slate-900">Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($credit->items as $item)
                            <tr class="py-1 border-b border-gray-300 border-dashed break-inside-avoid">

                                <td class="text-left">
                                    <p class="font-semibold uppercase text-[8px]">{{ $item->product->sku }}</p>
                                </td>

                                <td class="col-span-2 text-left">
                                    <p class="font-bold leading-snug text-[10px]">
                                        {{ ucwords($item->product->brand) }} {{ ucwords($item->product->name) }}
                                    </p>
                                    <span class="flex flex-wrap leading-snug text-[8px]">
                                        @foreach ($item->product->features as $feature)
                                            <span
                                                class="pr-1 font-semibold leading-snug text-[8px]"
                                            >{{ ucwords($feature->name) }}</span>
                                        @endforeach
                                    </span>
                                </td>
                                <td class="text-right">
                                    <p class="text-[10px]">{{ $item->qty }}</p>
                                </td>
                                <td class="text-right">
                                    <p class="text-[10px]">
                                        R {{ number_format($item->price, 2) }}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p class="text-[10px]">
                                        R {{ number_format($item->discount, 2) }}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p class="text-[10px]">
                                        R {{ number_format($item->line_total, 2) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="block mt-4 border-t border-gray-500 break-before-avoid-page break-inside-avoid">
                    <div class="grid grid-cols-4 break-after-avoid-page">
                        <p class="text-left whitespace-nowrap text-[10px]">
                            <span class="font-semibold uppercase">Sub Total: </span> R
                            {{ number_format($credit->getSubTotal(), 2) }}
                        </p>
                        <p class="text-left whitespace-nowrap text-[10px]">
                            <span class="font-semibold uppercase">Delivery:</span>
                            R {{ number_format($credit->delivery_charge, 2) }}
                        </p>
                        <p class="text-left whitespace-nowrap text-[10px]">
                            <span class="font-semibold uppercase">VAT: </span>
                            R {{ number_format(vat($credit->getTotal()), 2) }}
                        </p>
                        <p class="p-1 font-bold text-right whitespace-nowrap bg-gray-300 text-[10px]">
                            <span class="font-bold uppercase">Credit: </span>
                            R {{ number_format($credit->getTotal(), 2) }}
                        </p>
                    </div>
                </div>

                <section
                    class="pt-2 mt-6 break-before-avoid-page break-inside-avoid-page"
                    id="footer"
                >
                    <div class="py-1 text-center bg-gray-300 rounded">
                        <p class="font-bold uppercase text-[10px]">
                            thank you for your support
                        </p>
                    </div>
                    <div class="grid grid-cols-3 pt-2 break-before-avoid-page break-inside-avoid-page">
                        <x-document.banking reference="{{ $credit->number }}" />
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>

</html>
