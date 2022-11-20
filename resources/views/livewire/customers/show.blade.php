<div x-data="{ showStats: false }">

    <!-- Stats -->
    <div class="flex justify-between items-start">
        <div>
            <x-page-header>
                {{ $this->customer->name }}
            </x-page-header>
        </div>
        <div class="flex pt-4 space-x-4">
            <button
                class="link"
                x-on:click="showStats = !showStats"
            >toggle stats
            </button>
            <a
                class="link"
                href="{{ route('customers/edit', $this->customer->id) }}"
            >
                Edit
            </a>
        </div>
    </div>

    <div class="py-2">
        @if ($this->customer->salesperson_id)
            <p class="text-xs font-semibold text-slate-500">
                ( {{ $this->customer->salesperson->name ?? '' }})
            </p>
        @endif
    </div>
    <div
        x-show="showStats"
        x-transition
    >

        <div class="grid grid-cols-1 gap-5 mt-3 mb-2 sm:grid-cols-2 lg:grid-cols-3">
            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.tax-receipt class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Invoices</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R {{ number_format($lifetimeTransactions->where('type', 'invoice')->sum('amount'), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <button
                            class="link"
                            x-on:click="$wire.filter = 'invoice'"
                        >View all
                        </button>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.ccard class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Total Payments</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R
                            {{ number_format(abs($lifetimeTransactions->where('type', 'payment')->sum('amount')), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <button
                            class="link"
                            x-on:click="$wire.filter = 'payment'"
                        >View all
                        </button>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.chart-pie class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Outstanding</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R {{ number_format(abs($lifetimeTransactions->sum('amount')), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="invisible font-medium text-indigo-600 hover:text-indigo-500"
                            href="#"
                        >
                            View all
                        </a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-up class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Debits</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R
                            {{ number_format(abs($lifetimeTransactions->where('type', 'debit')->sum('amount')), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="#"
                            x-on:click="$wire.filter = 'debit'"
                        >
                            View all
                        </a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-right class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Credits</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R
                            {{ number_format(abs($lifetimeTransactions->where('type', 'credit')->sum('amount')), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="#"
                            x-on:click="$wire.filter = 'credit'"
                        >
                            View all
                        </a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div>
                    <div class="absolute p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.arrow-down class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-16">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">Refunds</p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            R
                            {{ number_format(abs($lifetimeTransactions->where('type', 'refund')->sum('amount')), 2) }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="#"
                            x-on:click="$wire.filter = 'refund'"
                        >
                            View all
                        </a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

        </div>
    </div>
    <!-- End Stats -->

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="py-2 px-4">
            <div>
                <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-6 lg:gap-y-0 lg:gap-x-2">
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
                    <div
                        class="grid grid-cols-2 col-span-1 gap-x-2 gap-y-2 mb-1 lg:grid-cols-6 lg:col-span-4 lg:gap-y-0">

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
                                target="sendStatement"
                            >
                                <x-icons.busy target="sendStatement" />
                                <span
                                    class="pl-2"
                                    wire:loading.class="hidden"
                                    wire:target="sendStatement"
                                >Email Statement</span>
                                <span
                                    class="hidden pl-2"
                                    wire:loading.class.remove="hidden"
                                    wire:target="sendStatement"
                                >Emailing</span>
                            </button>
                        </div>

                        <div class="w-full">
                            <button
                                class="w-full button-success"
                                wire:click="printStatement"
                            >
                                <x-icons.busy target="printStatement" />
                                <span
                                    class="pl-2"
                                    wire:loading.class="hidden"
                                    wire:target="printStatement"
                                >Print Statement</span>
                                <span
                                    class="hidden pl-2"
                                    wire:loading.class.remove="hidden"
                                    wire:target="printStatement"
                                >Printing</span>
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
                                <livewire:transactions.create :customer-id="$customerId" />
                            </div>
                        @endhasPermissionTo
                    </div>
                </div>
            </div>

            <!-- End -->

            <div class="py-3">
                {{ $transactions->links() }}
            </div>
        </div>

        @php
            $disabledTransactionTypes = ['credit', 'invoice'];
        @endphp

        {{-- Mobile Transactions --}}
        <div class="px-2">
            @forelse($transactions as $transaction)
                <div
                    class="grid grid-cols-3 py-2 px-1 w-full bg-white rounded lg:hidden dark:bg-slate-800 dark:even:bg-slate-700 even:bg-slate-100">
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
                                'text-xs text-pink-500 dark:text-pink-400' =>
                                    $transaction->type === 'invoice' ||
                                    $transaction->type === 'debit' ||
                                    $transaction->type === 'refund',
                                'text-xs text-green-500 dark:text-green-400' =>
                                    $transaction->type === 'payment' ||
                                    $transaction->type === 'credit' ||
                                    $transaction->type === 'warranty',
                            ])>
                                {{ strtoupper($transaction->type) }}
                            </span>
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                        </p>
                    </div>
                    <div class="flex justify-end items-center text-right">
                        <div>
                            <p class="text-xs text-slate-400">
                                Total: {{ number_format($transaction->amount, 2) }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Balance: {{ number_format($transaction->running_balance, 2) }}
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
                            @if (file_exists(public_path("storage/documents/$transaction->number.pdf")))
                                <p class="text-xs text-slate-400">Printed</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:hidden">
                    <x-table.empty></x-table.empty>
                </div>
            @endforelse
        </div>

        <!-- Desktop Transactions -->
        <div class="px-2">
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
                                        <span class="text-slate-500 dark:text-slate-400">{{ $transaction->id }}</span>
                                    @endif
                                </span>
                                <span @class([
                                    'text-xs text-pink-500 dark:text-pink-400' =>
                                        $transaction->type === 'invoice' ||
                                        $transaction->type === 'debit' ||
                                        $transaction->type === 'refund',
                                    'text-xs text-green-500 dark:text-green-400' =>
                                        $transaction->type === 'payment' ||
                                        $transaction->type === 'credit' ||
                                        $transaction->type === 'warranty',
                                ])>
                                    {{ strtoupper($transaction->type) }}
                                </span>
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $transaction->created_at->format('d-m-y H:i') }}</p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                {{ strtoupper($transaction->reference) }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_by }}</p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                            </p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right text-slate-500 dark:text-slate-400">
                            {{ number_format($transaction->amount, 2) }}
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right text-slate-500 dark:text-slate-400">
                            <span class="lg:hidden">BAL:</span> {{ number_format($transaction->running_balance, 2) }}
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right">
                            <div class="flex justify-end items-start">
                                <div>
                                    <button
                                        class="w-full button-success"
                                        wire:loading.attr="disabled"
                                        wire:target="getDocument({{ $transaction->id }})"
                                        wire:click="getDocument({{ $transaction->id }})"
                                    >
                                        <x-icons.busy target="getDocument({{ $transaction->id }})" />
                                        <span class="pl-2">Print</span>
                                    </button>
                                    @if (file_exists(public_path("storage/documents/$transaction->number.pdf")))
                                        <p class="text-xs text-slate-400">Printed</p>
                                    @endif
                                </div>
                            </div>
                        </x-table.row>
                    </x-table.body>

                @empty
                    <div class="hidden lg:block">
                        <x-table.empty></x-table.empty>
                    </div>
                @endforelse
            </x-table.container>
        </div>
    </div>
    <!-- Transactions End -->
</div>
