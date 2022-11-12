<div x-data="{ showStats: false }">
    <x-slide-over
        title="Add transaction"
        wire:model.defer="showAddTransactionForm"
    >
        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-form.input.label for="reference">
                        Reference
                    </x-form.input.label>

                    <div>
                        <x-form.input.text
                            id="reference"
                            type="text"
                            wire:model.defer="reference"
                        />
                    </div>
                    @error('reference')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="date">
                        Date
                    </x-form.input.label>
                    <div>
                        <x-form.input.text
                            id="date"
                            type="date"
                            wire:model.defer="date"
                        />
                    </div>
                    @error('date')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="type">
                        Type
                    </x-form.input.label>
                    <div>
                        <x-form.input.select
                            id="type"
                            wire:model.defer="type"
                        >
                            <option value="">Choose</option>
                            <option value="debit">Debit</option>
                            <option value="payment">Payment</option>
                            <option value="refund">Refund</option>
                        </x-form.input.select>
                    </div>
                    @error('type')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="amount">
                        Amount
                    </x-form.input.label>
                    <div>
                        <x-form.input.text
                            id="amount"
                            type="number"
                            wire:model.defer="amount"
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                        />
                    </div>
                    @error('amount')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <!-- Stats -->
    <div class="flex justify-between items-center">
        <div>
            <div class="pb-3">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-400">
                    {{ $this->customer->name }}
                </h3>
                @if ($this->customer->salesperson_id)
                    <p class="text-sm font-semibold text-slate-500">( {{ $this->customer->salesperson->name ?? '' }}
                        )</p>
                @endif
                <button
                    class="link"
                    x-on:click="showStats = !showStats"
                >toggle stats
                </button>
            </div>
        </div>
        <div>
            <a
                class="link"
                href="{{ route('customers/edit', $this->customer->id) }}"
            >
                Edit
            </a>
        </div>
    </div>
    <div
        x-show="showStats"
        x-transition
    >

        <dl class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 lg:grid-cols-3">
            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-600">
                        Total Invoices
                    </p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format($this->invoices->sum('amount'), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <button
                                class="link"
                                x-on:click="$wire.filter = 'invoice'"
                            >View all
                            </button>
                        </div>
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
                            R {{ number_format(abs($this->payments->sum('amount')), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <button
                                class="link"
                                x-on:click="$wire.filter = 'payment'"
                            >View all
                            </button>
                        </div>
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
                            R {{ number_format($this->transactions->sum('amount'), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="invisible font-medium text-indigo-600 hover:text-indigo-500"
                                href="#"
                            >
                                View all
                            </a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-up class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Debits</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->debits?->sum('amount')), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <button
                                class="link"
                                x-on:click="$wire.filter = 'debit'"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-right class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Credits</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->credits?->sum('amount')), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <button
                                class="link"
                                x-on:click="$wire.filter ='credit'"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-down class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Refunds</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->refunds?->sum('amount')), 2) }}
                        </p>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <button
                                class="link"
                                x-on:click="$wire.filter = 'refund'"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

        </dl>
    </div>
    <!-- End Stats -->

    <!-- Actions -->
    <div class="mt-3">
        <div
            class="grid grid-cols-1 gap-y-4 py-3 px-2 rounded-lg shadow lg:grid-cols-6 lg:gap-y-0 lg:gap-x-2 bg-slate-100 dark:bg-slate-900">
            <div>
                <div>
                    <x-form.input.label>
                        Search
                    </x-form.input.label>
                    <x-form.input.text
                        type="search"
                        wire:model="searchTerm"
                        autofocus
                    >
                    </x-form.input.text>
                </div>
                <button
                    class="link"
                    x-on:click="$wire.call('resetFilter')"
                >reset filter
                </button>
            </div>
            <div>
                <x-form.input.label>
                    No of records
                </x-form.input.label>
                <x-form.input.select
                    class="w-full rounded-md"
                    wire:model="recordCount"
                >
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    @if ($this->customer->transaction_count > 100)
                        <option value="{{ $this->customer->transactions_count }}">
                            {{ $this->customer->transactions_count }}</option>
                    @endif
                </x-form.input.select>
            </div>
            <div class="grid grid-cols-1 col-span-1 gap-x-2 gap-y-2 lg:grid-cols-6 lg:col-span-4 lg:gap-y-0">

                <div class="hidden col-span-6 lg:block">
                    {{-- Force alignment --}}
                </div>
                <div class="w-full">
                    <button
                        class="w-full button-success"
                        wire:click="updateBalances"
                    >
                        <x-icons.busy target="updateBalances" />
                        <span class="pl-2">Refresh balance</span>
                    </button>
                </div>

                <div class="w-full">
                    <button
                        class="w-full button-success"
                        wire:click="sendStatement"
                    >
                        <svg
                            class="w-4 h-4 text-slate-600 dark:text-slate-300"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            wire:loading
                            wire:loading.class="animate-spin-slow"
                            wire:target="sendStatement"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                            />
                        </svg>
                        <x-icons.busy target="sendStatement" />
                        <span class="pl-2">Email Statement</span>
                    </button>
                </div>

                <div class="w-full">
                    <button
                        class="w-full button-success"
                        wire:click="printStatement"
                    >
                        <x-icons.busy target="printStatement" />
                        <span class="pl-2">Print Statement</span>
                    </button>
                </div>

                <div class="w-full">
                    <button
                        class="w-full button-success"
                        wire:click="createOrder"
                    >
                        <x-icons.busy target="createOrder" />
                        <span class="pl-2">order</span>
                    </button>
                </div>

                <div class="w-full">
                    <a
                        class="w-full button-success"
                        href="{{ route('credits/create', $this->customer->id) }}"
                    >
                        <x-icons.busy target="''" />
                        <span class="pl-2">credit note</span>
                    </a>
                </div>

                @hasPermissionTo('add transactions')
                    <div class="w-full">
                        <button
                            class="w-full button-success"
                            wire:click="$toggle('showAddTransactionForm')"
                        >
                            <span class="pl-2">transaction</span>
                        </button>
                    </div>
                @endhasPermissionTo
            </div>
        </div>
    </div>

    <!-- End -->

    <!-- Transactions -->

    <div class="py-2">
        {{ $transactions->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-6">
            <x-table.heading>Transaction</x-table.heading>
            <x-table.heading>Reference</x-table.heading>
            <x-table.heading>Date</x-table.heading>
            <x-table.heading class="text-right">Amount</x-table.heading>
            <x-table.heading class="text-right">Balance</x-table.heading>
            <x-table.heading class="text-right">Document</x-table.heading>
        </x-table.header>
        @forelse($transactions as $transaction)
            @php
                $disabledTransactionTypes = ['credit', 'invoice'];
            @endphp
            <x-table.body class="hidden text-sm lg:grid lg:grid-cols-6">
                <x-table.row class="text-xs text-center lg:text-left">
                    <p>
                        <span>
                            @if (auth()->user()->hasPermissionTo('edit transactions') && !in_array($transaction->type, $disabledTransactionTypes))
                                <a
                                    class="link"
                                    href="{{ route('transactions/edit', $transaction->id) }}"
                                >
                                    {{ $transaction->id }}
                                </a>
                            @else
                                <span class="text-slate-500">{{ $transaction->id }}</span>
                            @endif
                        </span>
                        <span @class([
                            'text-xs font-bold text-red-500' => $transaction->type === 'invoice',
                            'text-xs font-bold text-green-500' => $transaction->type === 'payment',
                            'text-xs font-bold text-orange-600' => $transaction->type === 'debit',
                            'text-xs font-bold text-green-600' => $transaction->type === 'credit',
                            'text-xs font-bold text-yellow-500' => $transaction->type === 'refund',
                        ])>
                            {{ strtoupper($transaction->type) }}
                        </span>
                    </p>
                    <p class="text-xs text-slate-500">{{ $transaction->created_at }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <p class="text-xs font-semibold text-slate-500">{{ strtoupper($transaction->reference) }}</p>
                    <p class="text-xs text-slate-500">{{ $transaction->created_by }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <p class="text-xs text-slate-500">
                        {{ $transaction->date?->format('Y-m-d') ?? $transaction->created_at?->format('Y-m-d') }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right text-slate-500">
                    {{ number_format($transaction->amount, 2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right text-slate-500">
                    <span class="lg:hidden">BAL:</span> {{ number_format($transaction->running_balance, 2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <div class="flex justify-end items-start">
                        <div>
                            <button
                                class="button button-success"
                                wire:loading.attr="disabled"
                                wire:target="getDocument({{ $transaction->id }})"
                                wire:click="getDocument({{ $transaction->id }})"
                            >
                                <x-icons.busy target="getDocument({{ $transaction->id }})" />
                                Print
                            </button>
                            @if (file_exists(public_path("storage/documents/$transaction->uuid.pdf")))
                                <p class="text-xs text-slate-400">Printed</p>
                            @endif
                        </div>
                    </div>
                </x-table.row>
            </x-table.body>

            <div class="grid grid-cols-3 py-2 w-full bg-white border-b lg:hidden dark:bg-slate-900">
                <div>
                    <p>
                        <span>
                            @if (auth()->user()->hasPermissionTo('edit transactions') && !in_array($transaction->type, $disabledTransactionTypes))
                                <a
                                    class="link"
                                    href="{{ route('transactions/edit', $transaction->id) }}"
                                >
                                    {{ $transaction->id }}
                                </a>
                            @else
                                <span class="text-xs font-bold text-slate-500">{{ $transaction->id }}</span>
                            @endif
                        </span>
                        <span @class([
                            'text-xs font-bold text-red-500' => $transaction->type === 'invoice',
                            'text-xs font-bold text-green-500' => $transaction->type === 'payment',
                            'text-xs font-bold text-orange-600' => $transaction->type === 'debit',
                            'text-xs font-bold text-green-600' => $transaction->type === 'credit',
                            'text-xs font-bold text-yellow-500' => $transaction->type === 'refund',
                        ])>
                            {{ strtoupper($transaction->type) }}
                        </span>
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ $transaction->date?->format('Y-m-d') ?? $transaction->created_at?->format('Y-m-d') }}
                    </p>
                </div>
                <div class="flex justify-end items-center text-right">
                    <div>
                        <p class="text-xs text-slate-400">
                            {{ number_format($transaction->amount, 2) }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ number_format($transaction->running_balance, 2) }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-end items-start">
                    <div>
                        <button
                            class="button button-success"
                            wire:loading.attr="disabled"
                            wire:target="getDocument({{ $transaction->id }})"
                            wire:click="getDocument({{ $transaction->id }})"
                        >
                            <x-icons.busy target="getDocument({{ $transaction->id }})" />
                            Print
                        </button>
                        @if (file_exists(public_path("storage/documents/$transaction->uuid.pdf")))
                            <p class="text-xs text-slate-400">Printed</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
    <!-- Transactions End -->
</div>
