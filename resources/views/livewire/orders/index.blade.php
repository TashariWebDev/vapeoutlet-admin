<div
    x-data="{
        ordersCount: $wire.entangle('ordersCount')
    }"
    x-init="$watch('ordersCount', value => {
        if (value === 0) {
            confetti()
        }
    })"
>

    <x-modal x-data="{ show: $wire.entangle('quickViewCustomerAccountModal') }">
        <div class="pb-3">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Latest transactions</h3>
        </div>
        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            @if ($selectedCustomerLatestTransactions)
                <div class="py-6">
                    @forelse($selectedCustomerLatestTransactions as $transaction)
                        <div class="grid grid-cols-4 py-3">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $transaction->id }}
                                    {{ strtoupper($transaction->type) }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $transaction->created_at->format('d-m-y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{ strtoupper($transaction->reference) }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->created_by }}</p>
                            </div>
                            <div class="text-xs font-semibold text-right">
                                <p class="text-slate-500 dark:text-slate-400">
                                    {{ number_format($transaction->amount, 2) }}
                                </p>
                            </div>
                            <div class="text-xs font-semibold text-right">
                                <p class="text-slate-500 dark:text-slate-400">
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

    {{-- Desktop --}}
    <div class="mb-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="lg:px-4">

            <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-4 lg:gap-x-3 lg:px-0">
                <div class="">
                    <x-form.input.label>
                        Search
                    </x-form.input.label>
                    <x-form.input.text
                        type="search"
                        placeholder="search"
                        autofocus
                        wire:model="searchTerm"
                    />
                </div>

                <div>
                    <x-form.input.label>
                        Filter orders
                    </x-form.input.label>
                    <div
                        class="flex items-center py-2 mt-1 w-full bg-white rounded-md border divide-x border-slate-200 dark:divide-slate-600 dark:border-slate-700 dark:bg-slate-700">
                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-500 dark:text-slate-400',
                                'pl-3 w-1/2 text-sm text-left text-teal-400 dark:text-teal-500 font-semibold' =>
                                    $customerType === null,
                            ])
                            wire:click="$set('customerType',null)"
                        >
                            View all
                        </button>

                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-500 dark:text-slate-400',
                                'pl-3 w-1/2 text-sm text-left text-teal-400 dark:text-teal-500 font-semibold' =>
                                    $customerType === false,
                            ])
                            wire:click="$set('customerType',false)"
                        >
                            Retail
                        </button>

                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-500 dark:text-slate-400',
                                'pl-3 w-1/2 text-sm text-left text-teal-400 dark:text-teal-500 font-semibold' =>
                                    $customerType === true,
                            ])
                            wire:click="$set('customerType',true)"
                        >
                            Wholesale
                        </button>
                    </div>
                </div>

                <div>
                    <x-form.input.label>
                        No of records
                    </x-form.input.label>
                    <x-form.input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-form.input.select>
                </div>
                <div>
                    <x-form.input.label>
                        Status
                    </x-form.input.label>
                    <x-form.input.select wire:model="filter">
                        <option value="received">Received</option>
                        <option value="processed">Processed</option>
                        <option value="packed">Packed</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </x-form.input.select>
                </div>
            </div>

            <div class="py-4 px-2">
                {{ $orders->links() }}
            </div>

            @if ($filter === 'received')
                <div class="hidden lg:block">
                    <p class="pb-1 text-xs text-slate-500"> {{ $this->totalActiveOrders }} orders need to dispatched</p>
                </div>
                <div
                    class="hidden px-2 mx-auto mb-2 w-full h-3 bg-gradient-to-r from-teal-400 to-pink-400 rounded-r-full rounded-l-full lg:block">
                    <div
                        class="flex justify-end items-center py-1 px-2 h-full bg-transparent rounded-r-full rounded-l-full"
                        style="width: {{ round(($orders->total() / $this->totalActiveOrders) * 100 + 1) }}%"
                    >
                        <div
                            class="px-1 text-xs font-bold text-teal-900 whitespace-nowrap bg-transparent rounded-r rounded-l">
                            {{ round(($orders->total() / $this->totalActiveOrders) * 100) }} %
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="px-2">
            <x-table.container class="hidden lg:block">
                <x-table.header class="hidden lg:grid lg:grid-cols-5">
                    <x-table.heading>Order #
                        <button
                            class="@if ($direction === 'asc') text-teal-600 @endif"
                            wire:click="$set('direction','asc')"
                        >
                            &uparrow;
                        </button>
                        <button
                            class="@if ($direction === 'desc') text-teal-600 @endif"
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
                            <a
                                class="link"
                                href="{{ route('orders/show', $order->id) }}"
                            >{{ $order->number }}</a>
                            <div class="flex justify-between pt-1">
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $order->created_at->format('d-m-y H:i') }}
                                </p>
                                @if ($order->status != 'completed' && $order->status != 'cancelled')
                                    @if ($order->created_at->diffInDays(today()) > 0)
                                        <p @class([
                                            'rounded-l-full rounded-r-full px-1',
                                            'bg-yellow-200 text-yellow-800 dark:bg-yellow-100' =>
                                                $order->created_at->diffInDays(today()) <= 3,
                                            'bg-pink-200 text-pink-800' => $order->created_at->diffInDays(today()) > 3,
                                        ])>{{ $order->created_at->diffInDays(today()) }}
                                        </p>
                                    @else
                                        <div
                                            class="flex justify-center items-center px-2 bg-teal-200 rounded-r-full rounded-l-full">
                                            <p class="text-xs text-teal-900 leading-0">
                                                new
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </x-table.row>
                        <x-table.row class="">
                            <div class="flex justify-end lg:justify-between lg:items-end">
                                <div>
                                    <a
                                        class="link"
                                        href="{{ route('customers/show', $order->customer->id) }}"
                                    >{{ $order->customer->name }}</a>
                                    <div class="flex justify-between pt-1 space-x-2">
                                        <p @class([
                                            'text-xs',
                                            'text-pink-700 dark:text-pink-400' =>
                                                $order->customer->type() === 'wholesale',
                                            'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                                        ])>{{ $order->customer->type() }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $order->customer->salesperson->name ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <button
                                        class="flex justify-center items-center w-5 h-5 bg-teal-200 rounded-full dark:bg-teal-200"
                                        wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')"
                                    >
                                        <x-icons.view class="w-3 h-3 text-teal-700" />
                                    </button>
                                </div>
                            </div>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right">
                            @php
                                $orderTotal = to_rands($order->order_total);
                            @endphp
                            <p class="text-slate-500 dark:text-slate-400">
                                R {{ number_format($order->delivery_charge, 2) }}</p>
                        </x-table.row>
                        <x-table.row class="hidden p-2 text-right lg:block">
                            <p class="text-slate-500 dark:text-slate-400">R {{ number_format($orderTotal, 2) }}</p>
                        </x-table.row>
                        <x-table.row class="p-2 text-center lg:text-right">
                            <div class="flex justify-end items-start space-x-2">
                                <div>
                                    @hasPermissionTo('complete orders')
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
                                                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                                </span>
                                                Complete
                                            </button>
                                        @endif
                                    @endhasPermissionTo
                                </div>
                                <div>
                                    <button
                                        class="button button-success"
                                        wire:loading.attr="disabled"
                                        wire:target="getDocument"
                                        wire:click="getDocument({{ $order->id }})"
                                    >
                                        <span
                                            class="pr-2"
                                            wire:loading
                                            wire:target="getDocument({{ $order->id }})"
                                        >
                                            <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                        </span>
                                        Print
                                    </button>
                                    @if (file_exists(public_path("storage/documents/$order->number.pdf")))
                                        <p class="text-xs text-slate-400">Printed</p>
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
    <div class="grid grid-cols-1 gap-y-4 px-1 lg:hidden">
        @forelse($orders as $order)
            <div class="grid grid-cols-3 p-1 text-xs bg-white rounded shadow dark:bg-slate-800">
                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('orders/show', $order->id) }}"
                    >{{ $order->number }}</a>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $order->created_at->format('d-m-y H:i') }}
                    </p>
                </div>

                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('customers/show', $order->customer->id) }}"
                    >{{ $order->customer->name }}</a>

                    <div class="pt-1">
                        <p @class([
                            'text-xs',
                            'text-pink-700 dark:text-pink-400' =>
                                $order->customer->type() === 'wholesale',
                            'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                        ])>{{ $order->customer->type() }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $order->customer->salesperson->name ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="p-1 text-right">
                    <p class="font-semibold text-slate-500 dark:text-slate-400">
                        R {{ number_format($orderTotal, 2) }}
                    </p>
                    <p class="font-semibold text-slate-500 dark:text-slate-400">
                        R {{ number_format($order->delivery_charge, 2) }}
                    </p>
                </div>

                <div class="col-span-3 p-1 py-1 mt-3 w-full">
                    <p class="font-semibold text-slate-500 dark:text-slate-400">{{ $order->delivery->type ?? '' }}</p>
                </div>

                <div class="col-span-3 mt-3 w-full">
                    @if (file_exists(public_path("storage/documents/$order->number.pdf")))
                        <p class="text-xs text-slate-500 dark:text-slate-400">Printed</p>
                    @endif
                    <button
                        class="w-full button-success"
                        wire:loading.attr="disabled"
                        wire:target="getDocument"
                        wire:click="getDocument({{ $order->id }})"
                    >
                        <span
                            class="pr-2"
                            wire:loading
                            wire:target="getDocument({{ $order->id }})"
                        >
                            <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                        </span>
                        Print
                    </button>
                </div>

            </div>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </div>
</div>
