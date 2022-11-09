<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >
    <title></title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
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
    <div class="font-sans w-screen bg-white antialiased overflow-hidden">
        <div class="p-6 bg-white rounded min-h-screen flex flex-col">
            <section id="header"
                     class="pb-4"
            >
                <div class="grid grid-cols-2 border-b">
                    <div class="flex items-center space-x-6 w-full pb-2">
                        <div>
                            <img src="{{ config('app.url').'/logo.png' }}"
                                 class="w-16"
                                 alt="Vape Crew"
                            >
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
                            <li>{{ date('Y-m-d') }}</li>
                            <li class="capitalize">Statement</li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 space-x-2 pt-2">
                    <div class="border rounded">
                        <div class="bg-gray-700 px-1 rounded-t border border-gray-700">
                            <p class="text-white font-semibold uppercase text-xs">Customer Details</p>
                        </div>
                        <ul class="text-sm px-1 py-2">
                            <li>{{ ucwords($customer->name) }}</li>
                            <li>{{ $customer->phone }}</li>
                            <li>{{ $customer->email }}</li>
                            <li>{{ ucwords($customer->company) }}</li>
                            <li>{{ ucwords($customer->vat_number) }}</li>
                        </ul>
                    </div>
                </div>
            </section>

            <div id="body"
                 class="break-before-avoid-page"
            >
                <div class="w-full grid grid-cols-5 break-inside-avoid">
                    <div class="border text-left px-1 uppercase text-xs bg-gray-700 text-white">ID</div>
                    <div class="col-span-2 border text-left px-1 uppercase text-xs bg-gray-700 text-white">
                        Reference
                    </div>
                    <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Amount</div>
                    <div class="border px-1 text-right uppercase text-xs bg-gray-700 text-white">Balance</div>
                </div>

                <div class="break-before-avoid block">
                    @foreach($transactions as $transaction)
                        <div class="w-full grid grid-cols-5 break-after-avoid-page py-1">
                            <div class="p-1">
                                <p class="font-semibold text-xs uppercase">{{ $transaction->id }}</p>
                                <p class="font-semibold text-xs uppercase">
                                    {{ $transaction->date?->format('Y-m-d') ?? $transaction->created_at?->format('Y-m-d') }}
                                </p>
                            </div>
                            <div class="col-span-2 p-1">
                                <p class="text-left text-xs capitalize">
                                    {{ $transaction->type }}
                                </p>
                                <p class="text-xs font-bold capitalize">
                                    {{ $transaction->reference }}
                                </p>
                            </div>
                            <div class="p-1">
                                <p class="text-right text-xs font-mono">
                                    R {{ number_format($transaction->amount,2) }}
                                </p>
                            </div>
                            <div class="p-1">
                                <p class="text-right text-xs font-mono">
                                    R {{ number_format($transaction->running_balance,2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="block break-before-avoid-page py-3 mt-6 border-t border-b border-gray-500">
                    <div class="grid grid-cols-1 gap-2">
                        <p class="text-xs text-center whitespace-nowrap">
                            <span class="font-semibold">ACCOUNT BALANCE </span>
                            R {{ number_format($customer->getRunningBalance(),2) }}
                        </p>
                    </div>
                </div>
            </div>
            <section id="footer"
                     class="mt-6 border-t pt-2 break-before-avoid-page"
            >
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
                            <li class="font-semibold">First National Bank</li>
                            <li class="font-semibold">Sandton City</li>
                            <li class="font-mono mt-2">ACC: 62668652855</li>
                            <li class="font-mono ">REF: {{ $customer->name }}</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
