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
    <div class="overflow-hidden w-screen font-sans antialiased bg-white">
        <div class="flex flex-col p-6 min-h-screen bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2 border-b">
                    <x-document.company />
                    <div class="font-mono text-xs text-right">
                        <ul>
                            <li class="uppercase">{{ $transaction->created_by }}</li>
                            <li>{{ $transaction->created_at }}</li>
                            <li>{{ $transaction->number }}</li>
                            <li class="capitalize">{{ $transaction->type }} Note</li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($transaction->customer->name) }}</li>
                            <li>{{ $transaction->customer->phone }}</li>
                            <li>{{ $transaction->customer->email }}</li>
                            <li>{{ ucwords($transaction->customer->company) }}</li>
                            <li>{{ ucwords($transaction->customer->vat_number) }}</li>
                        </ul>
                    </div>
                </div>
            </section>

            <div
                class="break-before-avoid-page"
                id="body"
            >
                <div class="grid grid-cols-5 w-full break-inside-avoid">
                    <div class="px-1 text-xs text-left text-white uppercase bg-gray-700 border">ID</div>
                    <div class="px-1 text-xs text-left text-white uppercase bg-gray-700 border">Date</div>
                    <div class="col-span-2 px-1 text-xs text-left text-white uppercase bg-gray-700 border">Reference
                    </div>
                    <div class="px-1 text-xs text-right text-white uppercase bg-gray-700 border">Amount</div>
                </div>

                <div class="block break-before-avoid">
                    <div class="grid grid-cols-5 py-1 w-full break-after-avoid-page">
                        <div class="p-1">
                            <p class="text-xs font-semibold uppercase">{{ $transaction->id }}</p>
                        </div>
                        <div class="p-1">
                            <p class="text-xs font-semibold uppercase">
                                {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                            </p>
                        </div>
                        <div class="col-span-2 p-1">
                            <p class="text-xs font-bold capitalize">
                                {{ $transaction->reference }}
                            </p>
                        </div>
                        <div class="p-1">
                            <p class="font-mono text-xs text-right">R {{ number_format($transaction->amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="block py-3 mt-6 border-t border-b border-gray-500 break-before-avoid-page">
                    <div class="grid grid-cols-1 gap-2">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">ACCOUNT BALANCE </span>
                            R {{ number_format($transaction->customer->getRunningBalance(), 2) }}
                        </p>
                    </div>
                </div>
            </div>
            <section
                class="pt-2 mt-6 border-t break-before-avoid-page"
                id="footer"
            >
                <div class="py-1 text-center bg-gray-700 rounded">
                    <p class="text-xs text-white uppercase">
                        thank you for your support </p>
                </div>
                <div class="grid grid-cols-3 pt-2">
                    <x-document.banking reference="{{ $transaction->number }}" />
                </div>
            </section>
        </div>
    </div>
</body>

</html>
