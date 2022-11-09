<div x-data="{showStats:false}">

    <x-slide-over title="Add transaction"
                  wire:model.defer="showAddTransactionForm"
    >
        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <label for="reference"
                           class="text-xs text-gray-600"
                    >Transaction reference</label>
                    <div>
                        <input type="text"
                               id="reference"
                               wire:model.defer="reference"
                               class="w-full rounded-md"
                        />
                    </div>
                    @error('reference')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="date"
                           class="text-xs text-gray-600"
                    >Transaction date</label>
                    <div>
                        <input type="date"
                               id="date"
                               wire:model.defer="date"
                               class="w-full rounded-md"
                        />
                    </div>
                    @error('date')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="type"
                           class="text-xs text-gray-600"
                    >Transaction type</label>
                    <div>
                        <select
                            wire:model.defer="type"
                            id="type"
                            class="w-full rounded-md"
                        >
                            <option value="">Choose</option>
                            <option value="debit">Debit</option>
                            <option value="payment">Payment</option>
                            <option value="refund">Refund</option>
                        </select>
                    </div>
                    @error('type')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="amount"
                           class="text-xs text-gray-600"
                    >Transaction amount</label>
                    <div>
                        <input type="number"
                               id="amount"
                               wire:model.defer="amount"
                               class="w-full rounded-md"
                               step="0.01"
                               inputmode="numeric"
                               pattern="[0-9.]+"
                        />
                    </div>
                    @error('amount')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-3"/>
                        save
                    </button>
                </div>

                <div class="mt-4"
                     wire:loading
                     wire:target="save"
                >
                    <p class="text-green-500 text-xs">Processing! Please wait</p>
                </div>

            </form>
        </div>
    </x-slide-over>

    <!-- Stats -->
    <div class="flex justify-between items-end lg:items-center">
        <div>
            <h3 class="text-lg leading-6 font-bold text-slate-800 dark:text-slate-500">
                {{ $this->customer->name }} stats
                @if($this->customer->salesperson_id)
                    <span class="text-slate-500">( {{ $this->customer->salesperson->name ?? '' }} )</span>
                @endif
            </h3>
            <button class="link"
                    x-on:click="showStats = !showStats"
            >toggle stats
            </button>
        </div>
        <div>
            <a class="link"
               href="{{ route('customers/edit',$this->customer->id) }}"
            >
                Edit
            </a>
        </div>
    </div>
    <div x-cloak
         x-show="showStats"
         x-transition
    >

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.tax-receipt class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 dark:text-slate-600 truncate">Total Invoices</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format($this->invoices->sum('amount'),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="link"
                                    x-on:click="$wire.set('filter','invoice')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.ccard class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Payments</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->payments->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="link"
                                    x-on:click="$wire.set('filter','payment')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.chart-pie class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Outstanding</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format($this->transactions->sum('amount'),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="#"
                               class="font-medium invisible text-indigo-600 hover:text-indigo-500"
                            >
                                View all
                            </a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.arrow-up class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Debits</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->debits?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="link"
                                    x-on:click="$wire.set('filter','debit')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.arrow-right class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Credits</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->credits?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="link"
                                    x-on:click="$wire.set('filter','credit')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.arrow-down class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-500 truncate">Total Refunds</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                            R {{ number_format(abs($this->refunds?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="link"
                                    x-on:click="$wire.set('filter','refund')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

        </dl>
    </div>
    <!-- End Stats -->

    <!-- Transaction create -->
    <div class="mt-3">
        <div class="flex flex-wrap space-y-2 lg:space-y-0 lg:space-x-2 lg:justify-between items-center py-2">
            <div class="py-3 flex flex-wrap lg:justify-between items-center">
                <x-inputs.search wire:model="searchTerm"/>

                <button class="link pl-4"
                        x-on:click="$wire.call('resetFilter')"
                >reset filter
                </button>
            </div>
            <div class="flex flex-wrap space-y-2 lg:space-y-0 lg:space-x-2">
                <div class="w-full lg:w-auto">
                    <button
                        x-on:click="$wire.call('updateBalances')"
                        class="w-full lg:w-auto button-success"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-4 h-4 text-slate-600 dark:text-slate-300"
                             wire:loading
                             wire:loading.class="animate-spin-slow"
                             wire:target="updateBalances"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                            />
                        </svg>
                        <span class="pl-2">Update account balance</span>
                    </button>
                </div>
                <div class="w-full lg:w-auto">
                    <button
                        class="w-full lg:w-auto button-success"
                        wire:click="sendStatement"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-4 h-4 text-slate-600 dark:text-slate-300"
                             wire:loading
                             wire:loading.class="animate-spin-slow"
                             wire:target="sendStatement"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                            />
                        </svg>
                        <span class="pl-2">Email Statement</span>
                    </button>
                </div>
                <div class="w-full lg:w-auto">
                    <button x-on:click="$wire.call('createOrder')"
                            class="w-full lg:w-auto button-success"
                    >
                        order
                    </button>
                </div>
                <div class="w-full lg:w-auto">
                    <a href="{{ route('credits/create',$this->customer->id) }}"
                       class="w-full lg:w-auto button-success"
                    >
                        credit note
                    </a>
                </div>
                @hasPermissionTo('add transactions')
                <div class="w-full lg:w-auto">
                    <button class="w-full lg:w-auto button-success"
                            x-on:click="$wire.set('showAddTransactionForm',true)"
                    >
                        transaction
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
            <x-table.body class="hidden lg:grid lg:grid-cols-6 text-sm">
                <x-table.row class="text-xs text-center lg:text-left">
                    <p>
                        <span>
                            @if(auth()->user()->hasPermissionTo('edit transactions') && $transaction->type != 'invoice')
                                <a href="{{ route('transactions/edit',$transaction->id) }}"
                                   class="link"
                                >
                                {{ $transaction->id }}
                            </a>
                            @else
                                <span>{{ $transaction->id }}</span>
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
                    <p class="text-xs font-semibold">{{ strtoupper($transaction->reference) }}</p>
                    <p class="text-xs text-slate-400">{{ $transaction->created_by }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <p class="text-xs text-slate-400">{{ $transaction->date?->format('Y-m-d') ?? $transaction->created_at?->format('Y-m-d') }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    {{ number_format($transaction->amount,2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="lg:hidden">BAL:</span> {{ number_format($transaction->running_balance,2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <div class="flex items-start justify-end">
                        <div>
                            <button class="button button-success"
                                    wire:loading.attr="disabled"
                                    wire:target="getDocument({{$transaction->id}})"
                                    wire:click="getDocument({{$transaction->id}})"
                            >
                        <span class="pr-2"
                              wire:loading
                              wire:target="getDocument({{$transaction->id}})"
                        >
                            <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow"/>
                        </span>
                                Print
                            </button>
                            @if(file_exists(public_path("storage/documents/{$transaction->uuid}.pdf")))
                                <p class="text-xs text-slate-400">Printed</p>
                            @endif
                        </div>
                    </div>
                </x-table.row>
            </x-table.body>

            <div class="bg-slate-300 dark:bg-slate-900 lg:hidden w-full py-2 border-b grid grid-cols-3">
                <div>
                    <p>
                        <span>
                            @if(auth()->user()->hasPermissionTo('edit transactions') && $transaction->type != 'invoice')
                                <a href="{{ route('transactions/edit',$transaction->id) }}"
                                   class="link"
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
                <div class="text-right">
                    <p class="text-xs text-slate-400">
                        {{ number_format($transaction->amount,2) }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ number_format($transaction->running_balance,2) }}
                    </p>
                </div>
                <div class="flex items-start justify-end">
                    <div>
                        <button class="button button-success"
                                wire:loading.attr="disabled"
                                wire:target="getDocument({{$transaction->id}})"
                                wire:click="getDocument({{$transaction->id}})"
                        >
                        <span class="pr-2"
                              wire:loading
                              wire:target="getDocument({{$transaction->id}})"
                        >
                            <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow"/>
                        </span>
                            Print
                        </button>
                        @if(file_exists(public_path("storage/documents/{$transaction->uuid}.pdf")))
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
