<div>
    
    <div class="pb-4">
        <a href="{{ route('suppliers') }}"
           class="link"
        >
            &larr; Back to suppliers
        </a>
    </div>
    
    <div class="py-3 px-2 bg-white rounded-md shadow-sm dark:bg-slate-900">
        <div>
            <div>
                <h1 class="font-bold dark:text-white text-slate-900">
                    {{ $this->supplier->name }}
                    <span class="pl-4">
                     <a
                         class="link"
                         href="{{ route('suppliers/edit', $this->supplier->id) }}"
                     >
                        Edit supplier
                    </a>
                </span>
                </h1>
            </div>
        </div>
        
        <div class="grid grid-cols-1 py-4 lg:grid-cols-2 lg:gap-x-3">
            <div class="w-full lg:w-64">
                <x-input.text
                    type="search"
                    wire:model="searchQuery"
                    placeholder="search by reference"
                    autofocus
                    autocomplete="off"
                />
            </div>
            
            <div class="grid grid-cols-1 gap-y-2 mt-2 w-full lg:flex lg:justify-end lg:items-center lg:mt-0 lg:space-x-2">
                
                <livewire:purchases.create :supplierId="$this->supplier->id" />
                
                <button
                    class="button-success"
                    wire:click="createCredit"
                >
                    supplier credit note
                </button>
                
                <livewire:supplier-transactions.create :supplier="$this->supplier" />
            </div>
        </div>
        
        <div class="mt-2">
            <div class="grid grid-cols-2 px-2 rounded-md sm:grid-cols-2 lg:grid-cols-4 bg-slate-50 dark:bg-slate-800">
                <div class="py-2 px-4 rounded-md">
                    <p class="pt-1 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500">
                        Purchases
                    </p>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                               R {{ number_format($this->invoices->sum('amount'), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-md">
                    <p class="pt-1 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500">
                        Credits
                    </p>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                              R {{ number_format($this->credits->sum('amount'), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-md">
                    <p class="pt-1 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500">
                        Payments
                    </p>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                              R {{ number_format(abs($this->payments->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-md">
                    <p class="pt-1 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500">
                        Balance
                    </p>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                            R {{ number_format($this->supplier->latestTransaction?->running_balance, 2) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="p-4 px-2">
            {{ $supplierTransactions->links() }}
        </div>
    </div>
    
    @if ($purchases->count())
        <div class="py-4 px-2">
            <p class="text-xs font-semibold uppercase text-slate-800 dark:text-slate-300">PENDING PURCHASES</p>
        </div>
        <div class="bg-white rounded-md shadow-sm dark:bg-slate-900">
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-3">
                    <x-table.heading>Transaction</x-table.heading>
                    <x-table.heading>Status</x-table.heading>
                    <x-table.heading class="text-center lg:text-right">Amount</x-table.heading>
                </x-table.header>
                @forelse($purchases as $purchase)
                    <div class="grid grid-cols-2 lg:hidden">
                        <div>
                            <button
                                class="link"
                                wire:click="showPurchase('{{ $purchase->invoice_no }}')"
                            >{{ $purchase->id }} {{ strtoupper($purchase->invoice_no) }}
                            </button>
                            <p class="pt-1 text-xs text-slate-500">
                                {{ $purchase->created_at->format('d-m-y H:i') }}
                            </p>
                        </div>
                        
                        <div class="pt-1">
                            <p class="text-xs font-semibold text-rose-600">NOT PROCESSED</p>
                            <p class="text-xs text-rose-900"> {{ number_format($purchase->amount, 2) }}</p>
                        </div>
                    </div>
                    
                    <x-table.body class="hidden grid-cols-1 text-sm lg:grid lg:grid-cols-3">
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
                            <p class="text-xs font-semibold text-rose-600">NOT PROCESSED</p>
                        </x-table.row>
                        <x-table.row
                            class="text-center lg:text-right"
                        >{{ number_format($purchase->amount, 2) }}</x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty></x-table.empty>
                @endforelse
            </x-table.container>
        </div>
    @endif
    
    <div class="py-4 px-2">
        <p class="text-xs font-semibold uppercase text-slate-800 dark:text-slate-300">TRANSACTIONS</p>
    </div>
    <div class="mt-2 bg-white rounded-md shadow-sm dark:bg-slate-900">
        
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-7">
                <x-table.heading>Transaction</x-table.heading>
                <x-table.heading class="col-span-2">Description</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading class="text-right">Amount</x-table.heading>
                <x-table.heading class="text-right">Balance</x-table.heading>
                <x-table.heading class="text-right">Created by</x-table.heading>
            </x-table.header>
            @forelse($supplierTransactions as $transaction)
                <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-7">
                    <x-table.row class="text-left">
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
                            <p class="text-xs font-semibold">{{ $transaction->id }}
                                {{ strtoupper($transaction->reference) }}
                            </p>
                        @endif
                        <p class="text-xs text-slate-600 dark:text-slate-300">
                            {{ $transaction->created_at->format('d-m-y H:i') }}
                        </p>
                    </x-table.row>
                    <x-table.row class="col-span-2"
                    ><p class="uppercase">{{ $transaction->description }}</p></x-table.row>
                    <x-table.row
                    ><p class="text-xs">{{ $transaction->date }}</p></x-table.row>
                    <x-table.row
                    ><p class="lg:text-right">{{ number_format($transaction->amount, 2) }}</p></x-table.row>
                    <x-table.row
                    ><p class="lg:text-right">{{ number_format($transaction->running_balance, 2) }}</p>
                    </x-table.row>
                    <x-table.row
                    ><p class="lg:text-right">{{ $transaction->created_by }}</p>
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
        
        <!-- Transactions End -->
    </div>

</div>
