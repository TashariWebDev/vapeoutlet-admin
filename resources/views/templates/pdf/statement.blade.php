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
        <div class="p-4 bg-white rounded">
            <section
                class="pb-4"
                id="header"
            >
                <div class="grid grid-cols-2 border-b">
                    <x-document.company />
                    <div class="font-mono text-xs text-right">
                        <ul>
                            <li>{{ date('d-m-y') }}</li>
                            <li class="capitalize">Statement</li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 pt-2 space-x-2">
                    <div class="rounded border">
                        <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
                            <p class="text-xs font-semibold text-white uppercase">Customer Details</p>
                        </div>
                        <ul class="py-2 px-1 text-sm">
                            <li>{{ ucwords($customer->name) }}</li>
                            <li>{{ $customer->phone }}</li>
                            <li>{{ $customer->email }}</li>
                            <li>{{ ucwords($customer->company) }}</li>
                            <li>{{ ucwords($customer->vat_number) }}</li>
                        </ul>
                    </div>
                </div>
            </section>

            <div id="body">
                <table class="w-full">
                    <thead class="text-sm font-bold text-white uppercase bg-gray-900">
                        <tr>
                            <th class="text-left">ID</th>
                            <th class="col-span-2 text-left">Reference</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="py-1 border-b border-dashed break-inside-avoid">
                                <td class="text-left">
                                    <p class="text-xs font-semibold uppercase">{{ $transaction->id }}</p>
                                    <p class="text-xs font-semibold uppercase">
                                        {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                                    </p>
                                </td>
                                <td class="col-span-2 text-left">
                                    <p class="text-xs text-left capitalize">
                                        {{ $transaction->type }}
                                        @if ($transaction->type === 'payment')
                                            <span class="pl-2 font-semibold">{{ $transaction->created_by }}</span>
                                        @endif
                                    </p>
                                    <p class="text-xs font-bold capitalize">
                                        {{ $transaction->reference }}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p class="font-mono text-xs text-right">
                                        {{ number_format($transaction->amount, 2) }}
                                    </p>
                                </td>
                                <td class="text-right">
                                    <p class="font-mono text-xs text-right">
                                        {{ number_format($transaction->running_balance, 2) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="block py-3 mt-6 border-t border-b border-gray-500 break-before-avoid-page">
                <div class="grid grid-cols-1 gap-2">
                    <p class="text-xs text-center whitespace-nowrap">
                        <span class="font-semibold">ACCOUNT BALANCE </span>
                        R {{ number_format($customer->getRunningBalance(), 2) }}
                    </p>
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
                    <x-document.banking reference="{{ $customer->company ?? $customer->name }}" />
                </div>
            </section>
        </div>
    </div>
</body>

</html>
