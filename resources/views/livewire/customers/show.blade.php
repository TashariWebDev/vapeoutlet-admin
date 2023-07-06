<div>

    <div class="mt-4 bg-white rounded-lg shadow-md dark:bg-slate-900">
        <div class="py-2 px-4">
            <div>
                <h1 class="font-bold dark:text-white text-slate-900">
                    {{ $this->customer->name }}
                    <span class="pl-4">
                     <a
                         class="link"
                         href="{{ route('customers/edit', $this->customer->id) }}"
                     >
                        Edit customer
                    </a>
                </span>
                </h1>
            </div>
        </div>
        <div class="px-2 mx-auto">
            <div class="grid grid-cols-2 px-2 rounded-lg sm:grid-cols-2 lg:grid-cols-6 bg-slate-50 dark:bg-slate-800">
                <div class="py-2 px-4 rounded-lg">
                    <button class="link"
                            wire:click="$set('filter','invoice')"
                    >
                        Invoices
                    </button>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                               R {{ number_format($lifetimeTransactions->where('type', 'invoice')->sum('amount'), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-lg">
                    <button class="link"
                            wire:click="$set('filter','payment')"
                    >
                        Payments
                    </button>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                             R {{ number_format(abs($lifetimeTransactions->where('type', 'payment')->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-lg">
                    <p class="pt-1 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500">
                        Balance
                    </p>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                            R {{ number_format(abs($lifetimeTransactions->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-lg">
                    <button class="link"
                            wire:click="$set('filter','debit')"
                    >
                        Debits
                    </button>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                            R {{ number_format(abs($lifetimeTransactions->where('type', 'debit')->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-lg">
                    <button class="link"
                            wire:click="$set('filter','credit')"
                    >
                        Credits
                    </button>
                    <p>
                        <span class="text-lg font-bold tracking-tight uppercase whitespace-nowrap text-sky-800 dark:text-sky-400">
                            R {{ number_format(abs($lifetimeTransactions->where('type', 'credit')->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
                <div class="py-2 px-4 rounded-lg">
                    <button class="link"
                            wire:click="$set('filter','refund')"
                    >
                        Refunds
                    </button>
                    <p>
                        <span class="text-lg font-bold tracking-tight whitespace-nowrap text-sky-800 dark:text-sky-400">
                              R {{ number_format(abs($lifetimeTransactions->where('type', 'refund')->sum('amount')), 2) }}
                        </span>
                    </p>
                </div>
            </div>
            <button class="py-2 ml-4 link"
                    wire:click="$set('filter','')"
            >
                clear filters
            </button>
        </div>

        <div class="py-2 px-4">
            <div>
                <div class="grid grid-cols-1 gap-2 lg:grid-cols-10">
                    <div class="lg:col-span-2">
                        <div>
                            <x-input.label class="hidden">
                                Search
                            </x-input.label>
                            <x-input.text
                                type="search"
                                wire:model="searchQuery"
                                autofocus
                                autocomplete="off"
                                placeholder="search"
                            >
                            </x-input.text>
                        </div>
                    </div>
                    <div>
                        <x-input.label class="hidden">
                            No of records
                        </x-input.label>
                        <x-input.select
                            class="w-full rounded-md"
                            wire:model="recordCount"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            @if ($this->customer->transactions->count() > 50)
                                <option value="{{ $this->customer->transactions->count() }}">
                                    All
                                </option>
                            @endif
                        </x-input.select>
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
                            <span class="pl-2">New order</span>
                        </button>
                    </div>

                    <div class="block w-full">
                        <a
                            class="block w-full text-center button-success"
                            href="{{ route('credits/create', $this->customer) }}"
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

                    <div class="w-full">
                        <livewire:transactions.warranty.create :customer-id="$customerId" />
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
                </div>
            </div>

            <!-- End -->

            <div class="py-2 mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
    <!-- End Stats -->

    <!-- Actions -->
    <div class="mt-4 bg-white rounded-lg shadow dark:bg-slate-900">


        @php
            $disabledTransactionTypes = ['credit', 'invoice'];
        @endphp

        {{-- Mobile Transactions --}}
        <div class="px-2">
            @forelse($transactions as $transaction)
                <div
                    class="grid grid-cols-3 py-2 w-full bg-white rounded lg:hidden dark:bg-slate-800 dark:even:bg-slate-700 even:bg-slate-100"
                >
                    <div>
                        <p>
              <span>
                @if (auth()->user()->hasPermissionTo('edit transactions') &&
                        !in_array($transaction->type, $disabledTransactionTypes))
                      <a
                          class="link"
                          href="{{ route('transactions/edit', $transaction->id) }}"
                      >
                    {{ $transaction->id }}
                  </a>
                  @else
                      <span class="font-semibold uppercase dark:text-white text-[12px] text-slate-900">{{ $transaction->id }}</span>
                  @endif
              </span>
                            <span @class([
                  'text-[12px] uppercase font-semibold text-rose-500 dark:text-rose-400' =>
                      $transaction->type === 'invoice' ||
                      $transaction->type === 'debit' ||
                      $transaction->type === 'refund',
                  'text-[12px] uppercase font-semibold text-indigo-500 dark:text-indigo-400' =>
                      $transaction->type === 'payment' ||
                      $transaction->type === 'credit' ||
                      $transaction->type === 'warranty',
              ])>
                {{ strtoupper($transaction->type) }}
              </span>
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300">
                            {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                        </p>
                    </div>
                    <div class="flex justify-end items-center text-right">
                        <div>
                            <p class="font-bold dark:text-white text-[12px] text-slate-900">
                                Total: {{ number_format($transaction->amount, 2) }}
                            </p>
                            <p class="font-bold dark:text-white text-[12px] text-slate-900">
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
                                wire:key="transaction->{{ $transaction->id }}"
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
        <div>
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
                  @if (auth()->user()->hasPermissionTo('edit transactions') &&
                          !in_array($transaction->type, $disabledTransactionTypes))
                        <a
                            class="link"
                            href="{{ route('transactions/edit', $transaction->id) }}"
                        >
                      {{ $transaction->id }}
                    </a>
                    @else
                        <span class="font-semibold uppercase dark:text-white text-[12px] text-slate-900">{{ $transaction->id }}</span>
                    @endif
                </span>
                                <span @class([
                    'text-[12px] uppercase font-semibold text-rose-500 dark:text-rose-600' =>
                        $transaction->type === 'invoice' ||
                        $transaction->type === 'debit' ||
                        $transaction->type === 'refund',
                    'text-[12px] uppercase font-semibold text-indigo-500 dark:text-indigo-400' =>
                        $transaction->type === 'payment' ||
                        $transaction->type === 'credit' ||
                        $transaction->type === 'warranty',
                ])>
                  {{ strtoupper($transaction->type) }}
                </span>

                            </p>
                            <p class="uppercase text-[12px] text-slate-500 dark:text-slate-500">
                                {{ $transaction->created_at }}
                            </p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <p class="text-xs font-semibold">
                                {{ strtoupper($transaction->reference) }}</p>
                            <p class="uppercase text-[12px]">{{ $transaction->created_by }}
                            </p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <p class="font-semibold uppercase">
                                {{ $transaction->date?->format('d-m-y') ?? $transaction->created_at?->format('d-m-y') }}
                            </p>
                        </x-table.row>
                        <x-table.row class="font-bold text-center lg:text-right">
                            {{ number_format($transaction->amount, 2) }}
                        </x-table.row>
                        <x-table.row class="font-bold text-center lg:text-right">
                            <span class="lg:hidden">BAL:</span>
                            {{ number_format($transaction->running_balance, 2) }}
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right">
                            <div class="flex justify-end items-start">
                                <div>
                                    <button
                                        class="button-success"
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
