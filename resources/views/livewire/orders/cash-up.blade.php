<div>
    <x-modal x-data="{ show: $wire.entangle('quickViewCustomerAccountModal') }">
        <div class="pb-3">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Latest transactions</h3>
        </div>
        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            @if ($selectedCustomerLatestTransactions)
                <div class="py-6">
                    <div class="hidden grid-cols-4 gap-2 py-3 px-1 lg:grid">
                        <div class="text-xs font-semibold text-left text-slate-600 dark:text-slate-300">TYPE</div>
                        <div class="text-xs font-semibold text-left text-slate-600 dark:text-slate-300">REF</div>
                        <div class="text-xs font-semibold text-right text-slate-600 dark:text-slate-300">AMOUNT</div>
                        <div class="text-xs font-semibold text-right text-slate-600 dark:text-slate-300">BAL</div>
                    </div>

                    @forelse($selectedCustomerLatestTransactions as $transaction)
                        <div class="grid grid-cols-1 gap-2 py-3 px-1 rounded lg:grid-cols-4 dark:even:bg-gray-900 even:bg-sky-50">
                            <div>
                                <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                    {{ $transaction->id }}
                                    {{ strtoupper($transaction->type) }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-300">
                                    {{ $transaction->created_at }}</p>
                            </div>
                            <div class="px-1">
                                <p class="text-xs font-semibold break-words text-slate-600 dark:text-slate-300">
                                    {{ strtoupper($transaction->reference) }}
                                </p>
                                <p class="text-xs text-slate-600 dark:text-slate-300">{{ $transaction->created_by }}
                                </p>
                            </div>
                            <div class="text-xs font-semibold lg:text-right">
                                <p class="text-slate-600 dark:text-slate-300">
                                    <span class="lg:hidden">Amount</span>
                                    {{ number_format($transaction->amount, 2) }}
                                </p>
                            </div>
                            <div class="text-xs font-semibold lg:text-right">
                                <p class="text-slate-600 dark:text-slate-300">
                                    <span class="lg:hidden">Balance</span>
                                    {{ number_format($transaction->running_balance, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <div>
                            <p>No recent transaction</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </x-modal>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">
                New Payment
            </h3>
            <p class="text-xs font-bold text-slate-600 dark:text-slate-300">
                {{ $customer->name ?? '' }}
            </p>
        </div>

        <div>
            <form wire:submit.prevent="save()">
                <div class="py-3">
                    <x-input.label for="reference">
                        Reference
                    </x-input.label>

                    <div>
                        <x-input.text
                            id="reference"
                            type="text"
                            wire:model.defer="reference"
                        />
                    </div>
                    @error('reference')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="date">
                        Date
                    </x-input.label>
                    <div>
                        <x-input.text
                            id="date"
                            type="date"
                            wire:model.defer="date"
                        />
                    </div>
                    @error('date')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="amount">
                        Amount
                    </x-input.label>
                    <div>
                        <x-input.text
                            id="amount"
                            type="number"
                            wire:model.defer="amount"
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                        />
                    </div>
                    @error('amount')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <x-icons.busy target="save"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal x-data="{ show: $wire.entangle('quickViewNotesModal') }">
        <div class="pb-3">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Latest transactions</h3>
        </div>
        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            @if ($selectedOrderNotes)
                <div class="py-6">
                    @forelse($selectedOrderNotes as $note)
                        <div class="py-4">
                            @if ($note->customer_id)
                                <p class="text-xs uppercase dark:text-white text-slate-900">
                                    {{ $note->customer?->name }}
                                    on {{ $note->created_at->format('d-m-y H:i') }}</p>
                            @else
                                <p class="text-xs uppercase dark:text-white text-slate-900">{{ $note->user?->name }}
                                    on {{ $note->created_at->format('d-m-y H:i') }}</p>
                            @endif
                        </div>
                        @if ($note->body)
                            <div class="p-1 mt-2 rounded-md bg-slate-100 dark:bg-slate-700">
                                <p class="text-sm capitalize dark:text-white text-slate-900">{{ $note->body }}</p>
                            </div>
                        @endif
                    @empty
                        <div>
                            <p>No notes</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </x-modal>

    {{-- Desktop --}}
    <div class="py-3 bg-white rounded-lg shadow dark:bg-slate-900">
        <div class="lg:px-4">

            <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-4 lg:gap-x-3 lg:px-0">
                <div class="">
                    <x-input.label>
                        Search
                    </x-input.label>
                    <x-input.text
                        type="search"
                        placeholder="search"
                        autofocus
                        wire:model="searchQuery"
                    />
                    <x-input.helper>
                        Query Time {{ round($queryTime, 3) }} ms
                    </x-input.helper>
                </div>

                <div>
                    <x-input.label>
                        Filter orders
                    </x-input.label>
                    <div
                        class="grid grid-cols-3 py-2.5 mt-2 w-full rounded-md border divide-x bg-slate-100 border-slate-200 dark:divide-slate-600 dark:border-slate-900 dark:bg-slate-800"
                    >
                        <button
                            @class([
                                'h-full text-center text-[12px] text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-center text-[12px] font-bold uppercase' =>
                                    $customerType === null,
                            ])
                            wire:click="$set('customerType',null)"
                        >
                            View all
                        </button>

                        <button
                            @class([
                                'h-full text-[12px] text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-[12px] font-bold uppercase' =>
                                    $customerType === false,
                            ])
                            wire:click="$set('customerType',false)"
                        >
                            Retail
                        </button>

                        <button
                            @class([
                                'h-full text-[12px] text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-[12px] font-bold uppercase' =>
                                    $customerType === true,
                            ])
                            wire:click="$set('customerType',true)"
                        >
                            Wholesale
                        </button>
                    </div>
                </div>

                <div>
                    <x-input.label>
                        Status
                    </x-input.label>
                    <x-input.select wire:model="filter">
                        <option value="received">Received</option>
                        <option value="processed">Processed</option>
                        <option value="packed">Packed</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </x-input.select>
                </div>

                <div>
                    <x-input.label>
                        No of records
                    </x-input.label>
                    <x-input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-input.select>
                </div>

                <div class="grid grid-cols-2 gap-1 lg:hidden">
                    <button
                        class="@if ($direction === 'asc') text-sky-600 @endif border"
                        wire:click="$set('direction','asc')"
                    >
                        &uparrow;
                    </button>
                    <button
                        class="@if ($direction === 'desc') text-sky-600 @endif border"
                        wire:click="$set('direction','desc')"
                    >
                        &downarrow;
                    </button>
                </div>

            </div>

            <div class="py-6 px-2">
                {{ $orders->links() }}
            </div>
        </div>

        <div class="px-2">
            <x-table.container class="hidden lg:block">
                <x-table.header class="hidden lg:grid lg:grid-cols-5">
                    <x-table.heading>Order #
                        <button
                            class="@if ($direction === 'asc') text-sky-600 @endif"
                            wire:click="$set('direction','asc')"
                        >
                            &uparrow;
                        </button>
                        <button
                            class="@if ($direction === 'desc') text-sky-600 @endif"
                            wire:click="$set('direction','desc')"
                        >
                            &downarrow;
                        </button>
                    </x-table.heading>
                    <x-table.heading>customer</x-table.heading>
                    <x-table.heading class="text-right">delivery</x-table.heading>
                    <x-table.heading class="text-right">total</x-table.heading>
                    <x-table.heading class="text-right">invoice</x-table.heading>
                </x-table.header>
                @forelse($orders as $order)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-5">
                        <x-table.row class="text-left">
                            <div class="flex justify-between items-start pt-1 cursor-default">
                                <div>
                                    <a
                                        class="link"
                                        href="{{ route('orders/show', $order->id) }}"
                                        title="View Order {{ $order->number }}"
                                    >{{ $order->number }}</a>
                                    <p class="text-[12px]">
                                        {{ $order->created_at }}
                                    </p>
                                </div>

                                <p>
                                    {{ $order->status }}
                                </p>

                            </div>
                        </x-table.row>
                        <x-table.row class="">
                            <div class="flex justify-end lg:justify-between lg:items-start">
                                <div>
                                    <a
                                        class="link"
                                        href="{{ route('customers/show', $order->customer->id) }}"
                                        title="View {{ $order->customer->name }}'s Account"
                                    >{{ $order->customer->name }}</a>
                                    <div class="">
                                        <p class="font-semibold uppercase text-[10px]">
                                            {{ $order->customer->type() }}
                                        </p>
                                        <p class="uppercase text-[12px]">
                                            {{ $order->customer->salesperson->name ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-1">
                                    <button
                                        class="inline-flex items-center py-1 px-2 font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 text-[12px] bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                                        title="View {{ $order->customer->name }}'s Last Five Transactions"
                                        wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')"
                                    >
                                        VIEW
                                    </button>

                                    @if($order->notes_count)
                                        <button
                                            class="inline-flex items-center py-1 px-2 font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 text-[12px] bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                                            title="View order notes"
                                            wire:click.prefetch="quickViewNotes('{{ $order->id }}')"
                                        >
                                            NOTES
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </x-table.row>
                        <x-table.row class="text-center cursor-default lg:text-right">
                            <p
                                class="font-semibold uppercase text-[12px]"
                                title="Delivery Type"
                            >
                                {{ $order->delivery->description }}
                            </p>
                            <p
                                class="uppercase text-[12px]"
                            >
                                {{ $order->delivery->province }}
                            </p>
                        </x-table.row>
                        <x-table.row class="hidden p-2 text-right lg:block">
                            <p
                                class="font-bold uppercase cursor-default text-[12px]"
                                title="Order Total"
                            >
                                R {{ number_format(to_rands($order->order_total) + $order->delivery_charge, 2) }}
                            </p>
                        </x-table.row>
                        <x-table.row class="p-2 text-center lg:text-right">
                            <div class="flex justify-end items-start space-x-2">
                                <div>
                                    <button
                                        class="w-full button-success"
                                        wire:click="togglePaymentForm( {{ $order->customer_id }})"
                                    ><span class="pl-2">Add Payment</span>
                                    </button>
                                </div>

                                <div>
                                    @if ($order->status === 'shipped')
                                        <button
                                            class="button button-success"
                                            wire:loading.attr="disabled"
                                            wire:target="pushToComplete({{ $order->id }})"
                                            wire:click="pushToComplete({{ $order->id }})"
                                        >
                                            <span
                                                class="pr-2"
                                                wire:loading
                                                wire:target="pushToComplete({{ $order->id }})"
                                            >
                                                <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow"/>
                                            </span>
                                            Complete
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty></x-table.empty>
                @endforelse
            </x-table.container>
        </div>
    </div>

    {{-- Mobile --}}
    <div class="grid grid-cols-1 gap-y-4 px-1 mt-3 lg:hidden">
        @forelse($orders as $order)

            <div class="grid grid-cols-2 px-2 bg-white rounded shadow dark:bg-slate-800">
                <div class="py-1">
                    <a
                        class="link"
                        href="{{ route('orders/show', $order->id) }}"
                    ><p class="text-sm">{{ $order->number }}</p></a>
                </div>
                <div class="py-1">
                    <p class="text-sm font-semibold text-right text-slate-600 dark:text-slate-300">
                        R {{ number_format($order->getTotal(), 2) }}
                    </p>
                    <p class="text-xs text-right text-slate-600 dark:text-slate-300">
                        {{ $order->created_at->format('d-m-y H:i') }}
                    </p>
                </div>

                <div class="flex col-span-2 justify-between pt-3">
                    <div>
                        <a
                            class="link"
                            href="{{ route('customers/show', $order->customer->id) }}"
                        >
                            <p class="text-sm">{{ $order->customer->name }}</p>
                        </a>

                        <p @class([
                            'text-xs',
                            'text-rose-700 dark:text-rose-400' =>
                                $order->customer->type() === 'wholesale',
                            'text-sky-700 dark:text-sky-400' => $order->customer->type() === 'retail',
                        ])>
                            {{ $order->customer->type() }}
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-300">
                            {{ $order->customer->salesperson->name ?? '' }}
                        </p>
                    </div>

                    <div class="flex space-x-2">
                        <button
                            class="inline-flex items-center py-1 px-2 font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 text-[12px] bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                            title="View {{ $order->customer->name }}'s Last Five Transactions"
                            wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')"
                        >
                            VIEW
                        </button>

                        @if($order->notes_count)
                            <button
                                class="inline-flex items-center py-1 px-2 font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 text-[12px] bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                                title="View order notes"
                                wire:click.prefetch="quickViewNotes('{{ $order->id }}')"
                            >
                                NOTES
                            </button>
                        @endif
                    </div>
                </div>

                <div class="flex col-span-2 justify-between items-center my-3">
                    <div>
                        <button
                            class="w-full button-success"
                            wire:click="togglePaymentForm( {{ $order->customer_id }})"
                        ><span class="pl-2">Add Payment</span>
                        </button>
                    </div>
                    <div>
                        @if ($order->status === 'shipped')
                            <button
                                class="button button-success"
                                wire:loading.attr="disabled"
                                wire:target="pushToComplete({{ $order->id }})"
                                wire:click="pushToComplete({{ $order->id }})"
                            >
                                <span
                                    class="pr-2"
                                    wire:loading
                                    wire:target="pushToComplete({{ $order->id }})"
                                >
                                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow"/>
                                </span>
                                Complete
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </div>
</div>
