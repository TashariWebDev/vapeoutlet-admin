<div x-data>

    <x-slide-over title="Add transaction" wire:model.defer="showAddTransactionForm">
        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-input type="text" wire:model.defer="reference" label="reference"/>
                </div>
                <div class="py-3">
                    <x-input-number type="number" wire:model.defer="amount" label="amount"/>
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
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $this->supplier->name }} stats</h3>

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="relative bg-white pt-5 px-4 pb-6 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.tax-receipt class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Purchases</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format($this->supplier->invoices->sum('amount'),2) }}
                        </p>
                        @if($this->supplier->invoices?->count())
                            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                Average
                                spend
                                R {{  number_format($this->supplier->invoices->sum('amount') / ($this->supplier->invoices->count() ?: 1) ,2) }}
                                over {{ $this->supplier->invoices->count() }} invoices
                            </p>
                        @endif
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-6 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.ccard class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Payments</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format(abs($this->supplier->payments?->sum('amount')),2) }}
                        </p>
                        @if($this->supplier->payments?->count())
                            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                Last Payment
                                {{ $this->supplier->payments?->last()?->created_at->diffInDays(now()) }}
                                {{Str::plural('day', $this->supplier->payments?->last()?->created_at->diffInDays(now()) )}}
                                ago
                            </p>
                        @endif
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-6 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.chart-pie class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Outstanding</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format($this->supplier->latestTransaction?->running_balance,2) }}
                        </p>
                        @if($this->supplier->invoices?->count())
                            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
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
    <!-- End Stats -->

    <!-- Transaction create -->
    <div class="mt-3">
        <div class="flex flex-wrap items-center lg:justify-between lg:space-x-2">
            <x-inputs.search type="text" wire:model="searchTerm" class="w-full lg:w-72"
                             placeholder="search by reference"/>

            <button class="button-success w-full lg:w-72" x-on:click="@this.set('showAddTransactionForm',true)">
                <x-icons.plus class="w-5 w-5 mr-2"/>
                add transaction
            </button>
        </div>
    </div>
    <!-- End -->

    <!-- Transactions -->

    <div class="py-3">
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
                                class="font-semibold link">{{ $transaction->id }} {{ strtoupper($transaction->reference) }}
                        </button>
                        <p class="text-gray-500 text-xs pt-1">{{ $transaction->created_at }}</p>
                    @else
                        <p class="font-semibold">{{ $transaction->id }} {{ strtoupper($transaction->reference) }}</p>
                        <p class="text-gray-400">{{ $transaction->created_at }}</p>
                    @endif
                </x-table.row>
                <x-table.row class="text-center lg:text-right">{{ number_format($transaction->amount,2) }}</x-table.row>
                <x-table.row
                    class="text-center lg:text-right">{{ number_format($transaction->running_balance,2) }}</x-table.row>
                <x-table.row class="text-center lg:text-right">{{ $transaction->created_by}}</x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>

    <!-- Transactions End -->

</div>
