<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ ucwords(str_replace('Admin','',config('app.name'))) }} Debtors Report</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

            @page {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 portrait;
            }

            @page :first {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 portrait;
            }
        }
    </style>
</head>

<body class="text-[10px]">
    <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">
        
        <div class="break-inside-avoid break-after-avoid-page">
            <div class="px-4 text-[10px]">
                @foreach ($customers as $customer)
                    @if($salesperson_id)
                        @if($loop->first)
                            <div>{{ $customer->salesperson->name }}</div>
                        @endif
                    @endif
                    <div class="flex justify-between items-center pb-1 border-b border-dashed">
                        <div class="break-inside-avoid">
                            <p class="font-semibold uppercase text-slate-900 text-[10px]">
                                {{ $customer->name }} {{ $customer->company }}
                            </p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-500">
                                R {{ number_format(to_rands($customer->latest_transaction_sum_running_balance), 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-end border-t-4 border-dashed">
                    <td
                        class="text-right"
                        colspan="6"
                    >
                        <p class="font-bold">
                            R
                            {{ number_format(to_rands($customers->sum('latest_transaction_sum_running_balance')), 2) }}
                        </p>
                    </td>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
