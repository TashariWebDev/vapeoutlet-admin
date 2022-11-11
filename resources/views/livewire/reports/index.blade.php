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
            $credits = $transactions->total_refunds + $transactions->total_credits;
            $gross_sales = $transactions->total_sales + $credits;
        @endphp
        <h3 class="text-lg font-bold leading-6 text-slate-800 dark:text-slate-500">Current Month</h3>
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="text-sm font-medium text-slate-500 truncate">Sales</dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(to_rands(ex_vat($gross_sales)), 2) ?? '0.00' }}
                </dd>
                <dd class="mt-1 text-sm font-semibold tracking-tight text-slate-500">
                    {{ number_format(to_rands($gross_sales), 2) ?? '0.00' }}
                </dd>
            </div>

            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="text-sm font-medium text-slate-500 truncate">Purchases</dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(to_rands(ex_vat($purchases->total_purchases)), 2) }}
                </dd>
                <dd class="mt-1 text-sm font-semibold tracking-tight text-slate-500">
                    {{ number_format(to_rands($purchases->total_purchases), 2) }}
                </dd>
            </div>

            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="text-sm font-medium text-slate-500 truncate">Expenses</dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(to_rands($expenses->total_expenses), 2) ?? '0.00' }}
                </dd>
            </div>
        </dl>
    </div>

    <div>
        @php
            $credits = $transactions->total_refunds + $transactions->total_credits;
            $gross_sales = $transactions->total_sales + $credits;
        @endphp
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="text-sm font-medium text-slate-500 truncate">Refunds</dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(to_rands(ex_vat($transactions->total_refunds)), 2) ?? '0.00' }}
                </dd>
                <dd class="mt-1 text-sm font-semibold tracking-tight text-slate-500">
                    {{ number_format(to_rands($transactions->total_refunds), 2) ?? '0.00' }}
                </dd>
            </div>

            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="text-sm font-medium text-slate-500 truncate">Credits</dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(to_rands(ex_vat($transactions->total_credits)), 2) ?? '0.00' }}
                </dd>
                <dd class="mt-1 text-sm font-semibold tracking-tight text-slate-500">
                    {{ number_format(to_rands($transactions->total_credits), 2) ?? '0.00' }}
                </dd>
            </div>

            <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6 dark:bg-slate-900">
                <dt class="flex items-center space-x-4 text-sm font-medium text-slate-500 truncate">
                    Stock value
                    <button wire:click="getStockValue">
                        <x-icons.refresh
                            class="w-4 h-4"
                            wire:target="getStockValue"
                            wire:loading.class="animate-spin-slow"
                        />
                    </button>
                </dt>
                <dd class="mt-1 font-semibold racking-tight text-slate-900 dark:text-slate-400">
                    {{ number_format(ex_vat(to_rands($this->stockValue)), 2) ?? '0.00' }}
                </dd>
                <dd class="mt-1 text-sm font-semibold tracking-tight text-slate-500">
                    {{ number_format(to_rands($this->stockValue), 2) ?? '0.00' }}
                </dd>
            </div>
        </dl>
    </div>

    <div class="grid grid-cols-1 gap-3 py-6 lg:grid-cols-3">
        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            <button
                class="w-full button-success"
                x-on:click="@this.set('showStockTakeModal',true)"
            >Create stock take
            </button>

            <div class="py-4">
                <a
                    class="link"
                    href="{{ route('stock-takes') }}"
                >Stock Takes</a>
            </div>

            <x-modal
                title="Create a stock take"
                wire:model.defer="showStockTakeModal"
            >
                <form wire:submit.prevent="createStockTake">
                    <div class="overflow-y-scroll p-3 h-72 border shadow-inner">
                        @foreach ($this->brands as $brand)
                            <div class="p-1 mb-1 w-full text-xs rounded bg-slate-100">
                                <label>
                                    <input
                                        type="checkbox"
                                        value="{{ $brand->name }}"
                                        wire:model.defer="selectedBrands"
                                    >
                                </label>{{ $brand->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <button class="button-success">Create</button>
                    </div>
                </form>
            </x-modal>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $debtors = config('app.admin_url') . '/storage/documents/debtors-list.pdf';

                $debtorsExists = check_file_exist($debtors);
            @endphp

            <button
                class="w-full button-success"
                wire:click="getDebtorListDocument"
            >
                Debtors
            </button>

            <div class="py-4">
                @if ($debtorsExists)
                    <a
                        class="link"
                        href="{{ $debtors }}"
                        wire:loading.class="hidden"
                        wire:target="getDebtorsListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $creditors = config('app.admin_url') . '/storage/documents/creditors-list.pdf';

                $creditorsExists = check_file_exist($creditors);
            @endphp

            <button
                class="w-full button-success"
                wire:click="getCreditorsListDocument"
            >
                Creditors
            </button>

            <div class="py-4">
                @if ($creditorsExists)
                    <a
                        class="link"
                        href="{{ $creditors }}"
                        wire:loading.class="hidden"
                        wire:target="getCreditorsListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $expenses = config('app.admin_url') . '/storage/documents/expenses.pdf';

                $expensesExists = check_file_exist($expenses);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showExpenseForm',true)"
            >
                Expenses
            </button>

            <div class="py-4">
                @if ($expensesExists)
                    <a
                        class="link"
                        href="{{ $expenses }}"
                        wire:loading.class="hidden"
                        wire:target="getExpenseListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $purchases = config('app.admin_url') . '/storage/documents/purchases.pdf';

                $purchasesExists = check_file_exist($purchases);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showPurchasesForm',true)"
            >
                Purchases
            </button>

            <div class="py-4">
                @if ($purchasesExists)
                    <a
                        class="link"
                        href="{{ $purchases }}"
                        wire:loading.class="hidden"
                        wire:target="getPurchaseListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $credits = config('app.admin_url') . '/storage/documents/credits.pdf';

                $creditsExists = check_file_exist($credits);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showCreditsForm',true)"
            >
                Credits
            </button>

            <div class="py-4">
                @if ($creditsExists)
                    <a
                        class="link"
                        href="{{ $credits }}"
                        wire:loading.class="hidden"
                        wire:target="getCreditsListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $variances = config('app.admin_url') . '/storage/documents/variances.pdf';

                $variancesExists = check_file_exist($variances);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showVariancesForm',true)"
            >
                Variances
            </button>

            <div class="py-4">
                @if ($variancesExists)
                    <a
                        class="link"
                        href="{{ $variances }}"
                        wire:loading.class="hidden"
                        wire:target="getVariancesListDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $salesByDateRange = config('app.admin_url') . '/storage/documents/salesByDateRange.pdf';

                $salesByDateRangeExists = check_file_exist($salesByDateRange);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showSalesByDateRangeForm',true)"
            >
                Sales by date range
            </button>

            <div class="py-4">
                @if ($salesByDateRangeExists)
                    <a
                        class="link"
                        href="{{ $salesByDateRange }}"
                        wire:loading.class="hidden"
                        wire:target="getSalesByDateRangeDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-900">
            @php
                $stocksByDateRange = config('app.admin_url') . '/storage/documents/stockByDateRange.pdf';

                $stocksByDateRangeExists = check_file_exist($stocksByDateRange);
            @endphp

            <button
                class="w-full button-success"
                x-on:click="@this.set('showStocksByDateRangeForm',true)"
            >
                Stocks by date range
            </button>

            <div class="py-4">
                @if ($stocksByDateRangeExists)
                    <a
                        class="link"
                        href="{{ $stocksByDateRange }}"
                        wire:loading.class="hidden"
                        wire:target="getStocksByDateRangeDocument"
                    >
                        &darr; print
                    </a>
                @endif
            </div>
        </div>
    </div>

    <x-modal
        title="Get variances by date range"
        wire:model.defer="showVariancesForm"
    >
        <form wire:submit.prevent="getVariancesDocument">
            <div class="py-4">
                <x-input
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Get sales by date range"
        wire:model.defer="showStocksByDateRangeForm"
    >
        <form wire:submit.prevent="getStocksByDateRangeDocument">

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Get sales by date range"
        wire:model.defer="showSalesByDateRangeForm"
    >
        <form wire:submit.prevent="getSalesByDateRangeDocument">
            <div class="py-4">
                <x-input
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-4">
                <x-select wire:model.defer="selectedSalespersonId">
                    @foreach ($salespeople as $salesperson)
                        <option value="{{ $salesperson->id }}">{{ $salesperson->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Get credits by date range"
        wire:model.defer="showCreditsForm"
    >
        <form wire:submit.prevent="getCreditsListDocument">
            <div class="py-4">
                <x-input
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-4">
                <x-select wire:model.defer="selectedAdmin">
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->name }}">{{ $admin->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Get purchases by date range"
        wire:model.defer="showPurchasesForm"
    >
        <form wire:submit.prevent="getPurchaseListDocument">
            <div class="py-4">
                <x-input
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-4">
                <x-select wire:model.defer="selectedSupplierId">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Get expense by date range"
        wire:model.defer="showExpenseForm"
    >
        <form wire:submit.prevent="getExpenseListDocument">
            <div class="py-4">
                <x-input
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-4">
                <x-select
                    wire:model.defer="selectedExpenseCategory"
                    s
                >
                    @foreach ($expenseCategories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="py-2">
                <button class="button-success">Get report</button>
            </div>
        </form>
    </x-modal>
</div>
