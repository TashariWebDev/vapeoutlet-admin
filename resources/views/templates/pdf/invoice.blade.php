@php use App\Models\Order; @endphp
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

        @if ($model instanceof App\Models\Order)
            @if ($model->status === 'cancelled')
                <div
                    class="fixed right-0 bottom-0 z-10 max-w-7xl min-h-screen text-4xl font-extrabold text-red-600 opacity-20 transform">
                    <h1>CANCELLED</h1>
                </div>
            @endif
        @endif

        <div class="p-4 bg-white rounded">
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
                            <li class="uppercase">{{ $model->created_at }}</li>
                            <li class="capitalize">{{ $model->number }}</li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($model->customer->name) }}</li>
                            <li>{{ $model->customer->phone }}</li>
                            <li>{{ $model->customer->email }}</li>
                            <li>{{ ucwords($model->customer->company) }}</li>
                            <li>{{ ucwords($model->customer->vat_number) }}</li>
                        </ul>
                    </div>
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Delivery Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
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
                    <thead class="text-sm font-bold text-white uppercase bg-gray-900">
                        <tr>
                            <th class="text-left">SKU/CODE</th>
                            <th class="col-span-2 text-left">Item</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model->items as $item)
                            <tr class="py-1 border-b border-dashed break-inside-avoid">
                                <td class="text-left">
                                    <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                                </td>
                                <td class="col-span-2 text-left">
                                    <p class="text-xs font-bold">
                                        {{ ucwords($item->product->brand) }} {{ ucwords($item->product->name) }}
                                    </p>
                                    <span class="flex flex-wrap text-xs">
                                        @foreach ($item->product->features as $feature)
                                            <span
                                                class="pr-1 text-xs font-semibold">{{ ucwords($feature->name) }}</span>
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
                                        R {{ number_format($item->discount, 2) }}
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
                    class="block py-3 mt-8 border-t border-b border-gray-500 break-before-avoid-page break-inside-avoid">
                    <div class="grid grid-cols-5 gap-2 break-after-avoid-page">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">Sub Total </span> R
                            {{ number_format($model->getSubTotal(), 2) }}
                        </p>
                        <p class="col-span-2 text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">{{ ucwords($model->delivery->type) }} </span>
                            R {{ number_format($model->delivery_charge, 2) }}
                        </p>
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">Total </span>
                            R {{ number_format($model->getTotal(), 2) }}
                        </p>
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">VAT </span>
                            R {{ number_format(vat($model->getTotal()), 2) }}
                        </p>
                    </div>

                    <div class="block py-3 mt-6 border-t border-b border-gray-500 break-before-avoid-page">
                        <div class="grid grid-cols-1 gap-2">
                            <p class="text-xs text-center whitespace-nowrap">
                                <span class="font-semibold">ACCOUNT BALANCE </span>
                                R {{ number_format($model->customer->getRunningBalance(), 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                @if ($model->waybill)
                    <div>
                        <p class="text-xs">To track your order go to and enter your waybill number:</p>
                        <a
                            class="text-xs"
                            href="https://portal.thecourierguy.co.za/track"
                        >
                            https://portal.thecourierguy.co.za/track
                        </a>
                        @if ($model->waybill)
                            <p class="text-xs">Waybill number: <span class="uppercase">{{ $model->waybill }}</span></p>
                        @endif
                    </div>
                @endif

                <section
                    class="pt-2 mt-6 border-t break-before-avoid-page break-inside-avoid-page"
                    id="footer"
                >
                    <div class="py-1 text-center bg-gray-700 rounded">
                        <p class="text-xs text-white uppercase">
                            thank you for your support </p>
                    </div>
                    <div class="grid grid-cols-3 pt-2 break-before-avoid-page break-inside-avoid-page">
                        <div class="rounded border">
                            <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                                <p class="text-xs font-semibold text-white uppercase">Banking Details</p>
                            </div>
                            <ul class="p-1 text-xs">
                                <li class="font-semibold">Vape Crew (PTY) LTD</li>
                                <li class="font-semibold">First National Bank</li>
                                <li class="font-semibold">Sandton City</li>
                                <li class="mt-2 font-mono">ACC: 62668652855</li>
                                <li class="font-mono">REF: {{ $model->number }}</li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            @if ($model->notes->count())
                <div class="p-4 mt-4 bg-white rounded-md">

                    @foreach ($model->notes as $note)
                        @if (!$note->is_private)
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
                        @endif
                    @endforeach

                </div>
            @endif
        </div>
    </div>
</body>

</html>
