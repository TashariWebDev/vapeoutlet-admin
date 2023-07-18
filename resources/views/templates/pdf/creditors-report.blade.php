<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ ucwords(str_replace('admin','',config('app.name'))) }} Creditors Report</title>
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

<body>
    <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">

        <div class="break-inside-avoid break-after-avoid-page">

            <div class="px-4">
                @foreach ($suppliers as $supplier)
                    <div class="flex justify-between items-center pb-1 border-b border-dashed">
                        <div class="break-inside-avoid">
                            <p class="text-xs font-semibold uppercase text-slate-900">
                                {{ $supplier->name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500">
                                R {{ number_format(to_rands($supplier->latest_transaction_sum_running_balance), 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-end border-t-4 border-dashed">
                    <td
                        class="text-right"
                        colspan="6"
                    >
                        <p class="text-xs font-bold">
                            R
                            {{ number_format(to_rands($suppliers->sum('latest_transaction_sum_running_balance')), 2) }}
                        </p>
                    </td>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
