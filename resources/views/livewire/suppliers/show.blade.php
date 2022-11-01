<div x-data="{showStats:false}">

    <x-slide-over title="Add transaction"
                  wire:model.defer="showAddTransactionForm"
    >
        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-input type="text"
                             wire:model.defer="reference"
                             label="reference"
                    />
                </div>
                <div class="py-3">
                    <x-select wire:model.defer="type"
                              label=""
                    >
                        <option value="payment">Payment</option>
                        <option value="expense">Expense</option>
                    </x-select>
                </div>
                <div class="py-3">
                    <x-input-number type="number"
                                    wire:model.defer="amount"
                                    label="amount"
                    />
                </div>
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-3"/>
                        save
                    </button>
                </div>

            </form>
        </div>
    </x-slide-over>

    <!-- Stats -->
    <div class="p-4">
        <div class="flex flex-wrap lg:justify-between items-center space-y-2 lg:space-y-0">
            <div class="w-full lg:w-72">
                <h3 class="text-lg leading-6 font-bold text-slate-800 dark:text-slate-500">
                    {{ $this->supplier->name }}
                    stats
                </h3>
                <button class="link"
                        x-on:click="showStats = !showStats"
                >toggle stats
                </button>
            </div>
            <div class="w-full lg:w-72 lg:text-right">
                <a href="{{ route('suppliers/edit',$this->supplier->id) }}"
                   class="link"
                >Edit</a>
            </div>
        </div>

        <div
            x-cloak
            x-show="showStats"
            x-transition
        >
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                    <dt>
                        <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                            <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">Total
                                                                                                        Purchases</p>
                    </dt>
                    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->invoices->sum('amount'),2) }}
                            </p>
                            @if($this->supplier->invoices?->count())
                                <p class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-400 px-4 py-4 sm:px-6 text-xs font-semibold">
                                    Average
                                    spend
                                    R {{  number_format($this->supplier->invoices->sum('amount') / ($this->supplier->invoices->count() ?: 1) ,2) }}
                                    over {{ $this->supplier->invoices->count() }} invoices
                                </p>
                            @endif
                        </div>
                    </dd>
                </div>
                <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                    <dt>
                        <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                            <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Credits</p>
                    </dt>
                    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->credits->sum('amount'),2) }}
                            </p>
                        </div>
                    </dd>
                </div>

                <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                    <dt>
                        <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                            <x-icons.ccard class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Payments</p>
                    </dt>
                    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format(abs($this->supplier->payments?->sum('amount')),2) }}
                            </p>
                            @if($this->supplier->payments?->count())
                                <p class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-400 px-4 py-4 sm:px-6 text-xs font-semibold">
                                    Last Payment
                                    {{ $this->supplier->payments?->last()?->created_at->diffInDays(now()) }}
                                    {{Str::plural('day', $this->supplier->payments?->last()?->created_at->diffInDays(now()) )}}
                                    ago
                                </p>
                            @endif
                        </div>
                    </dd>
                </div>

                <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                    <dt>
                        <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                            <x-icons.chart-pie class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">Outstanding</p>
                    </dt>
                    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                        <div>
                            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                                R {{ number_format($this->supplier->latestTransaction?->running_balance,2) }}
                            </p>
                            @if($this->supplier->invoices?->count())
                                <p class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-400 px-4 py-4 sm:px-6 text-xs font-semibold">
                                    Last Purchase
                                    {{ $this->supplier->invoices?->last()?->created_at->diffInDays(now()) }}
                                    {{Str::plural('day', $this->supplier->invoices?->last()?->created_at->diffInDays(now()) )}}
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
    <div class="p-4">
        <div class="flex flex-wrap items-center lg:justify-between space-y-2 lg:space-y-0 lg:space-x-2">
            <x-inputs.search type="text"
                             wire:model="searchTerm"
                             placeholder="search by reference"
            />

            <div>
                <a href="{{ route('supplier-credits/create',$this->supplier->id) }}"
                   class="w-full lg:w-auto button-success"
                >
                    <x-icons.plus class="w-5 h-5 mr-2"/>
                    supplier credit
                </a>
                <button class="button-success w-full lg:w-72"
                        x-on:click="@this.set('showAddTransactionForm',true)"
                >
                    <x-icons.plus class="w-5 w-5 mr-2"/>
                    add transaction
                </button>
            </div>
        </div>
    </div>
    <!-- End -->

    @if($purchases->count())
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-2">
                <x-table.heading>Transaction</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
            </x-table.header>
            @forelse($purchases as $purchase)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-2 text-sm">
                    <x-table.row class="text-center lg:text-left">
                        <button wire:click="showPurchase('{{$purchase->invoice_no}}')"
                                class="font-semibold link"
                        >{{ $purchase->id }} {{ strtoupper($purchase->invoice_no) }}
                        </button>
                        <p class="text-gray-500 text-xs pt-1">{{ $purchase->created_at }}</p>
                    </x-table.row>
                    <x-table.row
                        class="text-center lg:text-right"
                    >{{ number_format($purchase->amount,2) }}</x-table.row>
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
            <x-table.body class="grid grid-cols-1 lg:grid-cols-4 text-sm">
                <x-table.row class="text-center lg:text-left">
                    @if($transaction->type == 'purchase')
                        <button wire:click="showPurchase('{{$transaction->reference}}')"
                                class="font-semibold link"
                        >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </button>
                        <p class="text-gray-500 text-xs pt-1">{{ $transaction->created_at }}</p>
                    @elseif($transaction->type == 'supplier credit')
                        <button wire:click="showSupplierCredit('{{$transaction->reference}}')"
                                class="font-semibold link"
                        >{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </button>
                        <p class="text-gray-500 text-xs pt-1">{{ $transaction->created_at }}</p>
                    @else
                        <p class="font-semibold">{{ $transaction->id }} {{ strtoupper($transaction->reference) }}</p>
                        <p class="text-gray-400">{{ $transaction->created_at }}</p>
                    @endif
                </x-table.row>
                <x-table.row class="text-center lg:text-right">{{ number_format($transaction->amount,2) }}</x-table.row>
                <x-table.row
                    class="text-center lg:text-right"
                >{{ number_format($transaction->running_balance,2) }}</x-table.row>
                <x-table.row class="text-center lg:text-right">{{ $transaction->created_by}}</x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>

    <!-- Transactions End -->

</div>
