<div x-data="{showStats:false}">
    @php
        function check_file_exist($url){
            $handle = @fopen($url, 'r');
            if(!$handle){
                return false;
            }else{
                return true;
            }
        }
    @endphp

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
                        <option value="debit">Debit</option>
                        <option value="payment">Payment</option>
                        <option value="refund">Refund</option>
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
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $this->customer->name }} stats
                @if($this->customer->salesperson_id)
                    <span class="text-gray-500">( {{ $this->customer->salesperson->name ?? '' }} )</span>
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
            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.tax-receipt class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Invoices</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format($this->customer->invoices->sum('amount'),2) }}
                        </p>
                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                            Average
                            spend
                            R {{  number_format($this->customer->invoices->sum('amount') / ($this->customer->invoices->count() ?: 1) ,2) }}
                            over {{ $this->customer->invoices->count() }} invoices
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="text-sm underline underline-offset-2 hover:text-yellow-500"
                                    x-on:click="@this.set('filter','invoice')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.ccard class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Payments</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format(abs($this->customer->payments?->sum('amount')),2) }}
                        </p>
                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                            Last Payment
                            {{ $this->customer->payments?->last()?->created_at->diffInDays(now()) }}
                            {{Str::plural('day', $this->customer->payments?->last()?->created_at->diffInDays(now()) )}}
                            ago
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="text-sm underline underline-offset-2 hover:text-yellow-500"
                                    x-on:click="@this.set('filter','payment')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.chart-pie class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Outstanding</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format($this->customer->latestTransaction?->running_balance,2) }}
                        </p>
                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                            Last Purchase
                            {{ $this->customer->invoices?->last()?->created_at->diffInDays(now()) }}
                            {{Str::plural('day', $this->customer->invoices?->last()?->created_at->diffInDays(now()) )}}
                            ago
                        </p>

                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
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

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.arrow-up class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Debits</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format(abs($this->customer->debits?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="text-sm underline underline-offset-2 hover:text-yellow-500"
                                    x-on:click="@this.set('filter','debit')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.arrow-right class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Credits</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format(abs($this->customer->credits?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="text-sm underline underline-offset-2 hover:text-yellow-500"
                                    x-on:click="@this.set('filter','credit')"
                            >View all
                            </button>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-gradient-gray rounded-md p-3">
                        <x-icons.arrow-down class="h-6 w-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total Refunds</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <div>
                        <p class="text-2xl font-semibold text-gray-900">
                            R {{ number_format(abs($this->customer->refunds?->sum('amount')),2) }}
                        </p>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <button class="text-sm underline underline-offset-2 hover:text-yellow-500"
                                    x-on:click="@this.set('filter','refund')"
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

                <button class="text-sm underline underline-offset-2 hover:text-yellow-500 ml-3"
                        x-on:click="@this.call('resetFilter')"
                >reset filter
                </button>
            </div>
            <div class="flex flex-wrap space-y-2 lg:space-y-0 lg:space-x-2">
                <div class="w-full lg:w-auto">
                    <button x-on:click="@this.call('updateBalances')"
                            class="w-full lg:w-auto flex justify-center items-center h-full w-10 mr-4"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-6 h-6 text-gray-600"
                             wire:loading.class="animate-spin-slow"
                             wire:target="updateBalances"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                            />
                        </svg>

                    </button>
                </div>
                <div class="w-full lg:w-auto">
                    <button x-on:click="@this.call('createOrder')"
                            class="w-full lg:w-auto button-success"
                    >
                        <x-icons.plus class="w-5 h-5 mr-2"/>
                        order
                    </button>
                </div>
                <div class="w-full lg:w-auto">
                    <a href="{{ route('credits/create',$this->customer->id) }}"
                       class="w-full lg:w-auto button-success"
                    >
                        <x-icons.plus class="w-5 h-5 mr-2"/>
                        credit note
                    </a>
                </div>
                @hasPermissionTo('add transactions')
                <div class="w-full lg:w-auto">
                    <button class="w-full lg:w-auto button-success"
                            x-on:click="@this.set('showAddTransactionForm',true)"
                    >
                        <x-icons.plus class="w-5 h-5 mr-2"/>
                        add transaction
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
        <x-table.header class="hidden lg:grid lg:grid-cols-5">
            <x-table.heading>Transaction</x-table.heading>
            <x-table.heading>Reference</x-table.heading>
            <x-table.heading class="text-right">Amount</x-table.heading>
            <x-table.heading class="text-right">Balance</x-table.heading>
            <x-table.heading class="text-right">Download</x-table.heading>
        </x-table.header>
        @forelse($transactions as $transaction)
            <x-table.body class="grid grid-cols-1 lg:grid-cols-5 text-sm">
                <x-table.row class="text-sm text-center lg:text-left">
                    <p>{{ $transaction->id }} {{ strtoupper($transaction->type) }}</p>
                    <p class="text-xs text-gray-500">{{ $transaction->created_at }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <p class="text-xs font-semibold">{{ strtoupper($transaction->reference) }}</p>
                    <p class="text-xs text-gray-400">{{ $transaction->created_by }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    {{ number_format($transaction->amount,2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="lg:hidden">BAL:</span> {{ number_format($transaction->running_balance,2) }}
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    @php
                        $document = config('app.admin_url')."/storage/documents/{$transaction->uuid}.pdf";
                        $documentExists = check_file_exist($document)
                    @endphp
                    @if($documentExists)
                        <a href="{{$document}}"
                           class="text-green-600 hover:text-green-700"
                        >&darr;
                         download
                        </a>
                    @else
                        <button class="text-gray-400"
                                wire:click="getDocument({{$transaction->id}})"
                        >request
                        </button>
                    @endif
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
    <!-- Transactions End -->
</div>
