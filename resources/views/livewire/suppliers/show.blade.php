<div x-data="{ showStats: false }">

    <!-- Stats -->
    <div class="p-4">
        <div class="flex flex-wrap items-center space-y-2 lg:justify-between lg:space-y-0">
            <x-page-header>
                {{ $this->supplier->name }}
            </x-page-header>
            <div class="flex items-center space-x-4">
                <button
                    class="link"
                    x-on:click="showStats = !showStats"
                >toggle stats
                </button>
                <a
                    class="link"
                    href="{{ route('suppliers/edit', $this->supplier->id) }}"
                >Edit</a>
            </div>
        </div>

        <div
            x-cloak
            x-show="showStats"
            x-transition
        >
            <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-800">
                    <dt>
                        <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                            <x-icons.tax-receipt class="w-6 h-6 text-teal-100 dark:text-teal-800" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Total Purchases
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                                R {{ number_format(to_rands($this->invoices->sum('amount')), 2) }}
                            </p>
                        </div>
                    </dd>
                </div>
                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-800">
                    <dt>
                        <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                            <x-icons.tax-receipt class="w-6 h-6 text-teal-100 dark:text-teal-800" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Total
                            Credits</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                                R {{ number_format($this->credits->sum('amount'), 2) }}
                            </p>
                        </div>
                    </dd>
                </div>

                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-800">
                    <dt>
                        <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                            <x-icons.ccard class="w-6 h-6 text-teal-100 dark:text-teal-800" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Total Payments
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                                R {{ number_format(abs($this->payments->sum('amount')), 2) }}
                            </p>
                        </div>
                    </dd>
                </div>

                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-800">
                    <dt>
                        <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                            <x-icons.chart-pie class="w-6 h-6 text-teal-100 dark:text-teal-800" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Outstanding</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                                R {{ number_format($this->supplier->latestTransaction?->running_balance, 2) }}
                            </p>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <!-- End Stats -->

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <!-- Transaction create -->
        <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-4 lg:gap-x-3">
            <div>
                <x-input.label for="search">
                    Search
                </x-input.label>
                <x-input.text
                    type="search"
                    wire:model="searchQuery"
                    placeholder="search by reference"
                    autofocus
                    autocomplete="off"
                />
                <x-input.helper>
                    Query Time {{ round($queryTime, 3) }} s
                </x-input.helper>
            </div>
            <div></div>
            <div class="flex items-end">
                <button
                    class="w-full button-success"
                    wire:click="createCredit"
                >
                    supplier credit note
                </button>
            </div>
            <div class="flex items-end w-full">
                <div class="w-full">
                    <livewire:supplier-transactions.create :supplier="$this->supplier" />
                </div>
            </div>
        </div>
        <!-- End -->

        <div class="border-b border-slate-100 dark:border-slate-700">
            @if ($purchases->count())
                <x-table.container>
                    <x-table.header class="hidden lg:grid lg:grid-cols-3">
                        <x-table.heading>Transaction</x-table.heading>
                        <x-table.heading>Status</x-table.heading>
                        <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
                    </x-table.header>
                    @forelse($purchases as $purchase)
                        <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-3">
                            <x-table.row class="text-center lg:text-left">
                                <button
                                    class="font-semibold link"
                                    wire:click="showPurchase('{{ $purchase->invoice_no }}')"
                                >{{ $purchase->id }} {{ strtoupper($purchase->invoice_no) }}
                                </button>
                                <p class="pt-1 text-xs text-slate-500">
                                    {{ $purchase->created_at->format('d-m-y H:i') }}</p>
                            </x-table.row>
                            <x-table.row>
                                <div
                                    class="py-1 px-4 w-48 text-center whitespace-nowrap bg-pink-100 rounded-r-full rounded-l-full">
                                    <p class="text-xs text-pink-900">NOT PROCESSED</p>
                                </div>
                            </x-table.row>
                            <x-table.row
                                class="text-center lg:text-right">{{ number_format($purchase->amount, 2) }}</x-table.row>
                        </x-table.body>
                    @empty
                        <x-table.empty></x-table.empty>
                    @endforelse
                </x-table.container>
            @endif
        </div>

        <!-- Transactions -->

        <div class="p-4 px-2">
            {{ $supplierTransactions->links() }}
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading>Transaction</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Balance</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Created by</x-table.heading>
            </x-table.header>
            @forelse($supplierTransactions as $transaction)
                <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        @if ($transaction->type == 'purchase')
                            <button
                                class="font-semibold link"
                                wire:click="showPurchase('{{ $transaction->reference }}')"
                            >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                            </button>
                        @elseif($transaction->type == 'supplier credit')
                            <button
                                class="font-semibold link"
                                wire:click="showSupplierCredit('{{ $transaction->reference }}')"
                            >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                            </button>
                        @else
                            <p class="font-semibold">{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                            </p>
                        @endif
                        <p class="text-slate-500 dark:text-slate-400">
                            {{ $transaction->created_at->format('d-m-y H:i') }}
                        </p>
                    </x-table.row>
                    <x-table.row
                        class="text-center lg:text-right">{{ number_format($transaction->amount, 2) }}</x-table.row>
                    <x-table.row
                        class="text-center lg:text-right">{{ number_format($transaction->running_balance, 2) }}</x-table.row>
                    <x-table.row class="text-center lg:text-right">{{ $transaction->created_by }}</x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>

        <!-- Transactions End -->
    </div>

</div>
