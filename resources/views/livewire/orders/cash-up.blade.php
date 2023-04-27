<div>
    <x-modal x-data="{ show: $wire.entangle('quickViewCustomerAccountModal') }">
        <div class="pb-3">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Latest transactions</h3>
        </div>
        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            @if ($selectedCustomerLatestTransactions)
                <div class="py-6">
                    @forelse($selectedCustomerLatestTransactions as $transaction)
                        <div class="grid grid-cols-4 py-3">
                            <div>
                                <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                    {{ $transaction->id }}
                                    {{ strtoupper($transaction->type) }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-300">
                                    {{ $transaction->created_at->format('d-m-y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                    {{ strtoupper($transaction->reference) }}
                                </p>
                                <p class="text-xs text-slate-600 dark:text-slate-300">{{ $transaction->created_by }}</p>
                            </div>
                            <div class="text-xs font-semibold text-right">
                                <p class="text-slate-600 dark:text-slate-300">
                                    {{ number_format($transaction->amount, 2) }}
                                </p>
                            </div>
                            <div class="text-xs font-semibold text-right">
                                <p class="text-slate-600 dark:text-slate-300">
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
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- Desktop --}}
    <div class="mb-2 bg-white rounded-lg shadow dark:bg-slate-900">
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
                        class="flex items-center py-2 mt-1 w-full bg-white rounded-md border divide-x border-slate-200 dark:divide-slate-600 dark:border-slate-700 dark:bg-slate-700"
                    >
                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-600 dark:text-slate-300',
                                'pl-3 w-1/2 text-sm text-left text-sky-500 dark:text-sky-500 font-semibold' =>
                                    $customerType === null,
                            ])
                            wire:click="$set('customerType',null)"
                        >
                            View all
                        </button>

                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-600 dark:text-slate-300',
                                'pl-3 w-1/2 text-sm text-left text-sky-500 dark:text-sky-500 font-semibold' =>
                                    $customerType === false,
                            ])
                            wire:click="$set('customerType',false)"
                        >
                            Retail
                        </button>

                        <button
                            @class([
                                'pl-3 w-1/2 text-xs text-left text-slate-600 dark:text-slate-300',
                                'pl-3 w-1/2 text-sm text-left text-sky-500 dark:text-sky-500 font-semibold' =>
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
                        No of records
                    </x-input.label>
                    <x-input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-input.select>
                </div>
                <div>
                    <x-input.label>
                        Sales Channel
                    </x-input.label>
                    <x-input.select wire:model="defaultSalesChannel">
                        @foreach ($salesChannels as $salesChannel)
                            <option value="{{ $salesChannel->id }}">{{ $salesChannel->name }}</option>
                        @endforeach
                    </x-input.select>
                </div>
            </div>

            <div class="py-4 px-2">
                {{ $orders->links() }}
            </div>
        </div>

        <div class="px-2">
            <x-table.container class="hidden lg:block">
                <x-table.header class="hidden lg:grid lg:grid-cols-4">
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
                    <x-table.heading class="text-right">total</x-table.heading>
                    <x-table.heading class="text-right">invoice</x-table.heading>
                </x-table.header>
                @forelse($orders as $order)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row class="text-left">
                            <a
                                class="link"
                                href="{{ route('orders/show', $order->id) }}"
                            >{{ $order->number }}</a>
                            <div class="flex justify-between pt-1">
                                <p class="text-xs text-slate-600 dark:text-slate-300">
                                    {{ $order->created_at->format('d-m-y H:i') }}
                                </p>
                                {{ $order->status }}
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
                                            'text-rose-700 dark:text-rose-400' =>
                                                $order->customer->type() === 'wholesale',
                                            'text-sky-700 dark:text-sky-400' => $order->customer->type() === 'retail',
                                        ])>{{ $order->customer->type() }}</p>
                                        <p class="text-xs text-slate-600 dark:text-slate-300">
                                            {{ $order->customer->salesperson->name ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <button
                                        class="flex justify-center items-center w-5 h-5 rounded-full bg-sky-200 dark:bg-sky-200"
                                        wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')"
                                    >
                                        <x-icons.view class="w-3 h-3 text-sky-700" />
                                    </button>
                                </div>
                            </div>
                        </x-table.row>
                        <x-table.row class="hidden p-2 text-right lg:block">
                            <p class="text-slate-600 dark:text-slate-300">
                                R {{ number_format(to_rands($order->order_total), 2) }}</p>
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
                                                <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
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
    <div class="grid grid-cols-1 gap-y-4 px-1 lg:hidden">
        @forelse($orders as $order)
            <div class="grid grid-cols-3 p-1 text-xs bg-white rounded shadow dark:bg-slate-800">
                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('orders/show', $order->id) }}"
                    >{{ $order->number }}</a>
                    <p class="text-xs text-slate-600 dark:text-slate-300">
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
                            'text-rose-700 dark:text-rose-400' =>
                                $order->customer->type() === 'wholesale',
                            'text-sky-700 dark:text-sky-400' => $order->customer->type() === 'retail',
                        ])>{{ $order->customer->type() }}</p>
                        <p class="text-xs text-slate-600 dark:text-slate-300">
                            {{ $order->customer->salesperson->name ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="p-1 text-right">
                    <p class="font-semibold text-slate-600 dark:text-slate-300">
                        R {{ number_format(to_rands($order->order_total), 2) }}
                    </p>
                </div>

                <div class="flex col-span-3 justify-between items-center">
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
                                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
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
