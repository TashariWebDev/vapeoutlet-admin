<div wire:poll.5000ms="$refresh">
    <div>
        <x-modal x-data="{ show: $wire.entangle('quickViewCustomerAccountModal') }">
            <div class="pb-3">
                <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Latest transactions</h3>
            </div>
            <div class="p-2 bg-white rounded-md dark:bg-slate-800">
                <div>
                    @if ($selectedCustomerLatestTransactions)
                        <div class="py-6">
                            <div class="hidden grid-cols-4 gap-2 py-3 px-1 lg:grid">
                                <div class="text-xs font-semibold text-left text-slate-600 dark:text-slate-300">TYPE
                                </div>
                                <div class="text-xs font-semibold text-left text-slate-600 dark:text-slate-300">REF
                                </div>
                                <div class="text-xs font-semibold text-right text-slate-600 dark:text-slate-300">AMOUNT
                                </div>
                                <div class="text-xs font-semibold text-right text-slate-600 dark:text-slate-300">BAL
                                </div>
                            </div>

                            @forelse($selectedCustomerLatestTransactions as $transaction)
                                <div class="grid grid-cols-1 gap-2 py-3 px-1 rounded lg:grid-cols-4 dark:even:bg-slate-900 even:bg-slate-50">
                                    <div>
                                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                            {{ $transaction->id }}
                                            {{ strtoupper($transaction->type) }}</p>
                                        <p class="text-xs text-slate-600 dark:text-slate-300">
                                            {{ $transaction->created_at }}</p>
                                    </div>
                                    <div class="px-1">
                                        <p class="text-xs font-semibold text-slate-600 [text-wrap:balance] dark:text-slate-300">
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
            </div>
        </x-modal>

        <x-modal x-data="{ show: $wire.entangle('quickViewNotesModal') }">
            <div class="pb-3">
                <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Order notes</h3>
            </div>
            <div class="p-2 bg-white rounded-md dark:bg-slate-800">
                <div>
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
            </div>
        </x-modal>

        <div class="px-4 bg-white rounded-md shadow-sm dark:bg-slate-900">

            <div class="grid grid-cols-1 gap-y-4 py-3 lg:grid-cols-4 lg:gap-x-3 lg:px-0">
                <div>
                    <x-input.text
                        type="search"
                        id="search"
                        placeholder="search"
                        wire:model.debounce.800ms="searchQuery"
                        autofocus
                        autocomplete="off"
                    />
                </div>

                <div>
                    <div
                        class="grid grid-cols-3 w-full rounded-md border divide-x py-[7px] bg-slate-100 border-slate-200 dark:divide-slate-600 dark:border-slate-900 dark:bg-slate-800"
                    >
                        <button
                            @class([
                                'h-full text-center text-sm text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-center text-sm font-bold uppercase' =>
                                    $customerType === null,
                            ])
                            wire:click="$set('customerType',null)"
                        >
                            View all
                        </button>

                        <button
                            @class([
                                'h-full text-sm text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-sm font-bold uppercase' =>
                                    $customerType === false,
                            ])
                            wire:click="$set('customerType',false)"
                        >
                            Retail
                        </button>

                        <button
                            @class([
                                'h-full text-sm text-slate-800 dark:text-slate-300 uppercase flex items-center justify-center',
                                'h-full text-sm font-bold uppercase' =>
                                    $customerType === true,
                            ])
                            wire:click="$set('customerType',true)"
                        >
                            Wholesale
                        </button>
                    </div>
                </div>

                <div>
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
                    <x-input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-input.select>
                </div>

                <div class="grid grid-cols-2 gap-1 font-black lg:hidden text-slate-400">
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

            <div class="py-2">
                {{ $orders->links() }}
            </div>
        </div>

        {{-- Desktop --}}
        <div class="py-2">
            <div class="mt-4 bg-white rounded-md shadow dark:bg-slate-900">
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
                        <x-table.heading class="text-left">delivery</x-table.heading>
                        <x-table.heading class="text-right">total</x-table.heading>
                        <x-table.heading class="text-right">invoice</x-table.heading>
                    </x-table.header>
                    <div>
                        @forelse($orders as $order)
                            <x-table.body class="grid grid-cols-1 lg:grid-cols-5">
                                <x-table.row class="text-left">
                                    <div class="flex justify-between items-center cursor-default">
                                        <div>
                                            <a
                                                class="link"
                                                href="{{ route('orders/show', $order->id) }}"
                                                title="View Order {{ $order->number }}"
                                            >{{ $order->number }}</a>
                                            <p class="text-xs text-slate-400">
                                                {{ $order->created_at }}
                                            </p>
                                        </div>
                                        @if ($order->status != 'completed' && $order->status != 'cancelled')
                                            @if ($order->created_at->diffInDays(now()) > 0)
                                                <p
                                                    title="Order Placed {{ $order->created_at->diffInDays(now()) }} Days Ago"
                                                    @class([
                                                        'rounded-l-full rounded-r-full px-1 font-semibold',
                                                        'inline-flex items-center py-1 px-2 font-medium text-yellow-500 rounded-md ring-1 ring-inset dark:text-yellow-400 text-[12px] bg-yellow-400/10 ring-yellow-400/50 dark:ring-yellow-400/20' =>
                                                            $order->created_at->diffInDays(now()) <= 3,
                                                        'inline-flex items-center py-1 px-2 font-medium text-rose-500 rounded-md ring-1 ring-inset dark:text-rose-400 text-[12px] bg-rose-400/10 ring-rose-400/50 dark:ring-rose-400/20' => $order->created_at->diffInDays(now()) > 3,
                                                    ])
                                                >{{ $order->created_at->diffInDays(now()) }}
                                                </p>
                                            @else
                                                <div
                                                    class="inline-flex items-center py-1 px-2 font-medium text-green-500 rounded-md ring-1 ring-inset dark:text-green-400 text-[12px] bg-green-400/10 ring-green-400/50 dark:ring-green-400/20"
                                                >
                                                    <p>
                                                        NEW
                                                    </p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </x-table.row>
                                <x-table.row>
                                    <div class="flex justify-end lg:justify-between">
                                        <div>
                                            <a
                                                class="link"
                                                href="{{ route('customers/show', $order->customer->id) }}"
                                                title="View {{ $order->customer->name }}'s Account"
                                            >{{ $order->customer->name }}</a>

                                            <div class="flex justify-start space-x-2">
                                                <p class="text-xs capitalize whitespace-nowrap divide-x divide-amber-50 text-slate-400 truncate">
                                                    {{ $order->customer->type() }}
                                                </p>
                                                <p class="text-xs capitalize whitespace-nowrap divide-x divide-amber-50 text-slate-400 truncate">
                                                    {{ $order->customer->salesperson->name  ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-1">

                                            @if($order->notes_count)
                                                <button
                                                    class="inline-flex items-center py-1 px-2 text-xs font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                                                    title="View order notes"
                                                    wire:click.prefetch="quickViewNotes('{{ $order->id }}')"
                                                >
                                                    NOTES
                                                </button>
                                            @endif
                                            <button
                                                class="inline-flex items-center py-1 px-2 text-xs font-medium text-purple-500 rounded-md ring-1 ring-inset dark:text-purple-400 bg-purple-400/10 ring-purple-400/50 dark:ring-purple-400/20"
                                                title="View {{ $order->customer->name }}'s Last Five Transactions"
                                                wire:click.prefetch="quickViewCustomerAccount('{{ $order->customer->id }}')"
                                            >
                                                VIEW
                                            </button>
                                        </div>
                                    </div>
                                </x-table.row>
                                <x-table.row class="px-2 text-center cursor-default lg:text-left text-semibold dark:text-slate-400">
                                    <p
                                        class="text-xs font-semibold uppercase whitespace-nowrap truncate"
                                        title="{{ $order->delivery->description }}"
                                    >
                                        {{ $order->delivery->description }}
                                    </p>
                                    <p
                                        class="uppercase text-[12px]"
                                    >
                                        {{ $order->delivery->province }}
                                    </p>
                                    @isset($order->waybill)
                                        <div class="flex items-center space-x-2">
                                            <p class="text-xs capitalize whitespace-nowrap text-slate-500 truncate dark:text-slate-500">
                                                Waybill/Tracking No. : </p>
                                            <x-click-to-copy
                                                text="{{$order->waybill}}"
                                                class="text-xs font-bold tracking-wide text-slate-900 dark:text-slate-400"
                                            > {{ $order->waybill }}</x-click-to-copy>
                                        </div>
                                    @endisset
                                </x-table.row>
                                <x-table.row class="hidden px-2 text-right lg:block">
                                    <p
                                        class="text-sm font-bold text-black uppercase cursor-default dark:text-slate-400"
                                        title="Order Total"
                                    >
                                        R {{ number_format(to_rands($order->order_total) + $order->delivery_charge, 2) }}
                                    </p>
                                </x-table.row>
                                <x-table.row class="px-2 text-center lg:text-right">
                                    <div class="flex justify-end items-start space-x-2">
                                        <div>
                                            @hasPermissionTo('complete orders')
                                            @if ($order->status === 'shipped')
                                                <button
                                                    class="button button-success"
                                                    title="Complete Order"
                                                    wire:loading.attr="disabled"
                                                    wire:target="pushToComplete({{ $order->id }})"
                                                    wire:click="pushToComplete({{ $order->id }})"
                                                >

                                                    Complete
                                                </button>
                                            @endif
                                            @endhasPermissionTo
                                        </div>
                                        <div>
                                            @if (
                                                ($order->status != 'shipped' &&
                                                    $order->status != 'completed' &&
                                                    $order->status != 'cancelled') ||
                                                    auth()->user()->hasPermissionTo('complete orders'))
                                                <button
                                                    class="button button-success"
                                                    title="Print Invoice"
                                                    wire:loading.attr="disabled"
                                                    wire:target="getDocument"
                                                    wire:click="getDocument({{ $order->id }})"
                                                >
                                                    Print
                                                </button>
                                                @if (file_exists(public_path("storage/".config('app.storage_folder')."/documents/$order->number.pdf")))
                                                    <p class="mt-1 text-xs text-slate-400">Printed</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </x-table.row>
                            </x-table.body>
                        @empty
                            <x-table.empty></x-table.empty>
                        @endforelse
                    </div>
                </x-table.container>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="grid grid-cols-1 gap-y-4 mt-3 shadow-sm lg:hidden">
            <div>
                @forelse($orders as $order)

                    <div class="grid grid-cols-2 px-2 bg-white rounded-md shadow-sm dark:bg-slate-800">
                        <div class="py-1">
                            <a
                                class="link"
                                href="{{ route('orders/show', $order->id) }}"
                            ><p class="text-sm">{{ $order->number }}</p></a>
                        </div>
                        <div class="pt-1">
                            <p class="text-sm font-semibold text-right text-slate-600 dark:text-slate-300">
                                R {{ number_format($order->getTotal(), 2) }}
                            </p>
                            <p class="text-xs text-right text-slate-600 dark:text-slate-300">
                                {{ $order->created_at->format('d-m-y H:i') }}
                            </p>
                        </div>
                        <div class="text-slate-600 dark:text-slate-300">
                            <p
                                class="text-xs font-semibold uppercase whitespace-nowrap truncate"
                                title="{{ $order->delivery->description }}"
                            >
                                {{ $order->delivery->description }}
                            </p>
                            <p
                                class="text-xs uppercase"
                            >
                                {{ $order->delivery->province }}
                            </p>
                            @isset($order->waybill)
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs capitalize whitespace-nowrap text-slate-500 truncate dark:text-slate-500">
                                        Waybill/Tracking No. : </p>
                                    <x-click-to-copy
                                        text="{{$order->waybill}}"
                                        class="text-xs font-bold tracking-wide text-slate-900 dark:text-slate-400"
                                    > {{ $order->waybill }}</x-click-to-copy>
                                </div>
                            @endisset
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
                        <div class="col-span-2 pb-2 mt-3 w-full">
                            @if ($order->status != 'shipped' && $order->status != 'completed' && $order->status != 'cancelled')
                                @if (file_exists(public_path("storage/documents/$order->number.pdf")))
                                    <p class="text-xs text-slate-600 dark:text-slate-300">Printed</p>
                                @endif
                                <button
                                    class="w-full button-success"
                                    wire:loading.attr="disabled"
                                    wire:target="getDocument"
                                    wire:click="getDocument({{ $order->id }})"
                                >
                                    Print
                                </button>
                            @endif
                        </div>
                    </div>

                @empty
                    <x-table.empty></x-table.empty>
                @endforelse
            </div>
        </div>
    </div>
</div>
