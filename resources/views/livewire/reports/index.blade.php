<div>

    @php
        function check_file_exist($url)
        {
            $handle = @fopen($url, 'r');
            if (!$handle) {
                return false;
            } else {
                return true;
            }
        }
    @endphp

    <div>
        @php
            $credits = ($transactions->total_refunds ?? 0 ) + ($transactions->total_credits ?? 0);
            $gross_sales = ($transactions->total_sales ?? 0) + $credits ;
        @endphp

        <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Sales</h3>
                <x-slot:footer>
                    <div class="flex items-baseline space-x-3">
                        <p class="font-bold text-sky-500">
                            {{ number_format(to_rands($gross_sales), 2) ?? '0.00' }}
                        </p>
                        <p class="text-sm text-sky-500">
                            {{ number_format(to_rands(ex_vat($gross_sales)), 2) ?? '0.00' }} (ex vat)
                        </p>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Purchases</h3>
                <x-slot:footer>
                    <div class="flex items-baseline space-x-3">
                        <p class="font-bold text-sky-500">
                            {{ number_format(to_rands($purchases->total_purchases ?? 0), 2) }}
                        </p>
                        <p class="text-sm text-sky-500">
                            {{ number_format(to_rands(ex_vat($purchases->total_purchases ?? 0)), 2) }} (ex vat)
                        </p>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Expenses</h3>
                <x-slot:footer>
                    <p class="font-bold text-sky-500">
                        {{ number_format(to_rands($expenses->total_expenses ?? 0), 2) ?? '0.00' }}
                    </p>
                </x-slot:footer>
            </x-stat-container>
            @if($transactions)
                <x-stat-container>
                    <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Refunds</h3>
                    <x-slot:footer>
                        <p class="font-bold text-sky-500">
                            {{ number_format(to_rands($transactions->total_refunds ?? 0), 2) ?? '0.00' }}
                        </p>
                    </x-slot:footer>
                </x-stat-container>
            @endif

            @if($transactions)
                <x-stat-container>
                    <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Credits</h3>
                    <x-slot:footer>
                        <p class="font-bold text-sky-500">
                            {{ number_format(to_rands($transactions->total_credits ?? 0), 2) ?? '0.00' }}
                        </p>
                    </x-slot:footer>
                </x-stat-container>
            @endif

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Stock value</h3>
                <x-slot:footer>
                    <div class="flex justify-between items-center">
                        <div class="flex items-baseline space-x-3">
                            <p class="font-bold text-sky-500">
                                {{ number_format(to_rands($this->stockValue ?? 0), 2) }}
                            </p>
                            <p class="text-sm text-sky-500">
                                {{ number_format(to_rands(ex_vat($this->stockValue ?? 0)), 2) ?? '0.00' }} (ex vat)
                            </p>
                        </div>
                        <button wire:click="getStockValue">
                            <x-icons.refresh
                                class="w-4 h-4 text-sky-500"
                                wire:target="getStockValue"
                                wire:loading.class="animate-spin-slow"
                            />
                        </button>
                    </div>
                </x-slot:footer>
            </x-stat-container>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 py-6 lg:grid-cols-3">

        <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
            <h2 class="font-bold text-slate-500">Financial Reports</h2>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.sales-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.debtor-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.expense-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.transaction-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.payment-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.credit-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.discount-report />
        </div>

        <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
            <h2 class="font-bold text-slate-500">Inventory Reports</h2>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.creditors-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.purchase-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.stock-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.variances-report />
        </div>

    </div>

</div>
