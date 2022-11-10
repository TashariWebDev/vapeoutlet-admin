<div
    class="py-1 px-2 rounded-md"
    x-data=""
>

    <div class="grid grid-cols-1 gap-y-2 pb-1 lg:grid-cols-4 lg:gap-x-1">
        <div class="">
            <x-form.input.label>
                Search
            </x-form.input.label>
            <x-form.input.text
                type="search"
                placeholder="search"
                wire:model="searchTerm"
            />
        </div>

        <div>
            <x-form.input.label>
                Filters
            </x-form.input.label>
            <div class="mt-1 rounded-r-md rounded-l-md border border-slate-700">
                <div
                    class="flex grid grid-cols-3 items-center py-2.5 px-2 w-full bg-white rounded-r-md rounded-l-md dark:bg-slate-700">
                    <button
                        @class([
                            'text-xs px-1 text-slate-400 text-center font-bold',
                            'text-green-400' => $customerType === null,
                        ])
                        wire:click="$set('customerType',null)"
                    >VIEW ALL
                    </button>
                    <button
                        @class([
                            'text-xs px-1 text-slate-400 text-center font-bold',
                            'text-blue-400' => $customerType === false,
                        ])
                        wire:click="$set('customerType',false)"
                    >RETAIL
                    </button>
                    <button
                        @class([
                            'text-xs px-1 text-slate-400 text-center font-bold',
                            'text-pink-400' => $customerType === true,
                        ])
                        wire:click="$set('customerType',true)"
                    >WHOLESALE
                    </button>
                </div>
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

    <x-modal wire:model.defer="quickViewCustomerAccountModal">
        @if ($selectedCustomerLatestTransactions)
            <div class="py-6">
                @forelse($selectedCustomerLatestTransactions as $transaction)
                    <div class="grid grid-cols-4 py-0.5 border-b">
                        <div>
                            <p class="text-xs font-semibold"> {{ $transaction->id }}
                                {{ strtoupper($transaction->type) }}</p>
                            <p class="text-xs text-slate-500">{{ $transaction->created_at }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold">{{ strtoupper($transaction->reference) }}</p>
                            <p class="text-xs text-slate-400">{{ $transaction->created_by }}</p>
                        </div>
                        <div class="text-xs font-semibold text-right">
                            <p>{{ number_format($transaction->amount, 2) }}</p>
                        </div>
                        <div class="text-xs font-semibold text-right">
                            <p>{{ number_format($transaction->running_balance, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <div>
                        <p>No recent transaction</p>
                    </div>
                @endforelse
            </div>
        @endif
    </x-modal>

    <div class="py-2">
        {{ $orders->links() }}
    </div>

    @if ($filter === 'received')
        <div>
            @if ($orders->total() === 0)
                <button x-on:click="confetti()">&#128512; <span class="text-xs text-white">click here</span></button>
            @else
                <p class="pb-1 text-xs text-slate-500"> {{ $this->totalActiveOrders }} orders need to dispatched</p>
            @endif
        </div>
        <div
            class="hidden px-2 mb-2 w-full h-3 bg-gradient-to-r from-green-600 to-red-600 rounded-r rounded-l lg:block">
            <div
                class="flex justify-end items-center py-1 h-full bg-transparent rounded-r rounded-l"
                style="width: {{ round(($orders->total() / $this->totalActiveOrders) * 100 + 1) }}%"
            >
                <div class="px-1 text-xs text-white whitespace-nowrap bg-transparent rounded-r rounded-l">
                    {{ round(($orders->total() / $this->totalActiveOrders) * 100) }} %
                </div>
            </div>
        </div>
    @endif

    {{-- Desktop --}}
    <x-table.container class="hidden lg:block">
        <x-table.header class="hidden lg:grid lg:grid-cols-5">
            <x-table.heading>Order #
                <button
                    class="@if ($direction === 'asc') text-green-600 @endif"
                    wire:click="$set('direction','asc')"
                >
                    &uparrow;
                </button>
                <button
                    class="@if ($direction === 'desc') text-green-600 @endif"
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
                        <p class="text-xs">
                            {{ $order->created_at }}
                        </p>
                        @if ($order->created_at->diffInDays(today()) > 0)
                            <p @class([
                                'rounded-l-full rounded-r-full px-1',
                                'bg-yellow-600 text-yellow-200 dark:bg-yellow-900' =>
                                    $order->created_at->diffInDays(today()) <= 3,
                                'bg-red-800 text-red-100' => $order->created_at->diffInDays(today()) > 3,
                            ])>{{ $order->created_at->diffInDays(today()) }}
                            </p>
                        @else
                            <div
                                class="flex justify-center items-center px-2 bg-green-800 rounded-r-full rounded-l-full">
                                <p class="text-xs text-green-200 leading-0">
                                    new
                                </p>
                            </div>
                        @endif
                    </div>
                </x-table.row>
                <x-table.row class="">
                    <div class="flex justify-center lg:justify-between lg:items-start">
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
                                <p class="text-xs text-slate-500">
                                    {{ $order->customer->salesperson->name ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <button wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')">
                                <x-icons.view class="w-4 h-4 link" />
                            </button>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    @php
                        $orderTotal = to_rands($order->order_total);
                    @endphp
                    <p>R {{ number_format($order->delivery_charge, 2) }}</p>
                    <p>
                        <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery->type ?? '' }}
                    </p>
                </x-table.row>
                <x-table.row class="hidden p-2 text-right lg:block">
                    <p>R {{ number_format($orderTotal, 2) }}</p>
                </x-table.row>
                <x-table.row class="p-2 text-center lg:text-right">
                    @php
                        $transaction = $order->customer->transactions->where('reference', '=', $order->number)->first();
                    @endphp

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
                                wire:click="getDocument({{ $transaction->id }})"
                            >
                                <span
                                    class="pr-2"
                                    wire:loading
                                    wire:target="getDocument({{ $transaction->id }})"
                                >
                                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                </span>
                                Print
                            </button>
                            @if (file_exists(public_path("storage/documents/$transaction->uuid.pdf")))
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

    {{-- Mobile --}}
    <div class="grid grid-cols-1 gap-y-4 px-1 lg:hidden">
        @forelse($orders as $order)
            <div class="grid grid-cols-3 text-xs bg-white rounded dark:bg-slate-900">
                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('orders/show', $order->id) }}"
                    >{{ $order->number }}</a>
                    <p class="text-xs text-slate-500">
                        {{ $order->created_at->format('Y-m-d') }}
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
                        <p class="text-xs text-slate-500">
                            {{ $order->customer->salesperson->name ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="p-1 text-right">
                    <p class="font-semibold text-slate-600 dark:text-slate-400">
                        R {{ number_format($orderTotal, 2) }}
                    </p>
                    <p class="font-semibold text-slate-600 dark:text-slate-400">
                        R {{ number_format($order->delivery_charge, 2) }}
                    </p>
                </div>

                <div class="col-span-3 p-1 py-1 mt-3 w-full">
                    <p class="font-semibold text-slate-600 dark:text-slate-400">{{ $order->delivery->type ?? '' }}</p>
                </div>

                <div class="col-span-3 mt-3 w-full">
                    @if (file_exists(public_path("storage/documents/$transaction->uuid.pdf")))
                        <p class="text-xs text-slate-400">Printed</p>
                    @endif
                    <button
                        class="w-full button-success"
                        wire:loading.attr="disabled"
                        wire:target="getDocument"
                        wire:click="getDocument({{ $transaction->id }})"
                    >
                        <span
                            class="pr-2"
                            wire:loading
                            wire:target="getDocument({{ $transaction->id }})"
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
