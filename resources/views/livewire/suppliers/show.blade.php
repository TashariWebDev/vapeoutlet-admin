<div x-data="{ showStats: false }">

    <x-slide-over
        title="Add transaction"
        wire:model.defer="showAddTransactionForm"
    >
        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-input
                        type="text"
                        wire:model.defer="reference"
                        label="reference"
                    />
                </div>
                <div class="py-3">
                    <x-select
                        wire:model.defer="type"
                        label=""
                    >
                        <option value="payment">Payment</option>
                        <option value="expense">Expense</option>
                    </x-select>
                </div>
                <div class="py-3">
                    <x-input-number
                        type="number"
                        wire:model.defer="amount"
                        label="amount"
                    />
                </div>
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="mr-3 w-5 h-5" />
                        save
                    </button>
                </div>

            </form>
        </div>
    </x-slide-over>

    <!-- Stats -->
    <div class="p-4">
        <div class="flex flex-wrap items-center space-y-2 lg:justify-between lg:space-y-0">
            <div class="w-full lg:w-72">
                <h3 class="text-lg font-bold leading-6 text-slate-800 dark:text-slate-500">
                    {{ $this->supplier->name }}
                    stats
                </h3>
                <button
                    class="link"
                    x-on:click="showStats = !showStats"
                >toggle stats
                </button>
            </div>
            <div class="w-full lg:w-72 lg:text-right">
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
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                    <dt>
                        <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                            <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-600">Total
                            Purchases</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->invoices->sum('amount'), 2) }}
                            </p>
                            @if ($this->supplier->invoices?->count())
                                <p
                                    class="absolute inset-x-0 bottom-0 py-4 px-4 text-xs font-semibold sm:px-6 bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-slate-400">
                                    Average
                                    spend
                                    R
                                    {{ number_format($this->supplier->invoices->sum('amount') / ($this->supplier->invoices->count() ?: 1), 2) }}
                                    over {{ $this->supplier->invoices->count() }} invoices
                                </p>
                            @endif
                        </div>
                    </dd>
                </div>
                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                    <dt>
                        <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                            <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Credits</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->credits->sum('amount'), 2) }}
                            </p>
                        </div>
                    </dd>
                </div>

                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                    <dt>
                        <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                            <x-icons.ccard class="w-6 h-6 text-green-100 dark:text-slate-500" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Payments</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format(abs($this->supplier->payments?->sum('amount')), 2) }}
                            </p>
                            @if ($this->supplier->payments?->count())
                                <p
                                    class="absolute inset-x-0 bottom-0 py-4 px-4 text-xs font-semibold sm:px-6 bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-slate-400">
                                    Last Payment
                                    {{ $this->supplier->payments?->last()?->created_at->diffInDays(now()) }}
                                    {{ Str::plural('day', $this->supplier->payments?->last()?->created_at->diffInDays(now())) }}
                                    ago
                                </p>
                            @endif
                        </div>
                    </dd>
                </div>

                <div
                    class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                    <dt>
                        <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                            <x-icons.chart-pie class="w-6 h-6 text-green-100 dark:text-slate-500" />
                        </div>
                        <p class="ml-16 text-sm font-medium text-slate-500 truncate">Outstanding</p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->latestTransaction?->running_balance, 2) }}
                            </p>
                            @if ($this->supplier->invoices?->count())
                                <p
                                    class="absolute inset-x-0 bottom-0 py-4 px-4 text-xs font-semibold sm:px-6 bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-slate-400">
                                    Last Purchase
                                    {{ $this->supplier->invoices?->last()?->created_at->diffInDays(now()) }}
                                    {{ Str::plural('day', $this->supplier->invoices?->last()?->created_at->diffInDays(now())) }}
                                    ago
                                </p>
                            @endif
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <!-- End Stats -->

    <!-- Transaction create -->
    <div
        class="grid grid-cols-1 gap-y-4 py-3 px-2 rounded-lg shadow lg:grid-cols-4 lg:gap-x-3 bg-slate-100 dark:bg-slate-900">
        <div>
            <x-form.input.label for="search">
                Search
            </x-form.input.label>
            <x-form.input.text
                type="search"
                wire:model="searchTerm"
                placeholder="search by reference"
                autofocus
            />
        </div>
        <div></div>
        <div class="flex items-end">
            <a
                class="w-full button-success"
                href="{{ route('supplier-credits/create', $this->supplier->id) }}"
            >
                supplier credit note
            </a>
        </div>
        <div class="flex items-end">
            <button
                class="w-full button-success"
                x-on:click="$wire.set('showAddTransactionForm',true)"
            >
                add transaction
            </button>
        </div>
    </div>
    <!-- End -->

    @if ($purchases->count())
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-2">
                <x-table.heading>Transaction</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
            </x-table.header>
            @forelse($purchases as $purchase)
                <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-2">
                    <x-table.row class="text-center lg:text-left">
                        <button
                            class="font-semibold link"
                            wire:click="showPurchase('{{ $purchase->invoice_no }}')"
                        >{{ $purchase->id }} {{ strtoupper($purchase->invoice_no) }}
                        </button>
                        <p class="pt-1 text-xs text-slate-500">{{ $purchase->created_at }}</p>
                    </x-table.row>
                    <x-table.row
                        class="text-center lg:text-right">{{ number_format($purchase->amount, 2) }}</x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    @endif

    <!-- Transactions -->

    <div class="p-4">
        {{ $transactions->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-4">
            <x-table.heading>Transaction</x-table.heading>
            <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
            <x-table.heading class="text-center lg:text-right">Balance</x-table.heading>
            <x-table.heading class="text-center lg:text-right">Created by</x-table.heading>
        </x-table.header>
        @forelse($transactions as $transaction)
            <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-4">
                <x-table.row class="text-center lg:text-left">
                    @if ($transaction->type == 'purchase')
                        <button
                            class="font-semibold link"
                            wire:click="showPurchase('{{ $transaction->reference }}')"
                        >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </button>
                        <p class="pt-1 text-xs text-slate-500">{{ $transaction->created_at }}</p>
                    @elseif($transaction->type == 'supplier credit')
                        <button
                            class="font-semibold link"
                            wire:click="showSupplierCredit('{{ $transaction->reference }}')"
                        >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </button>
                        <p class="pt-1 text-xs text-slate-500">{{ $transaction->created_at }}</p>
                    @else
                        <p class="font-semibold">{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </p>
                        <p class="text-slate-400">{{ $transaction->created_at }}</p>
                    @endif
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
