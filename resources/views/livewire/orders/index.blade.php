<div class="rounded-md px-2 py-1">
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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-y-2 lg:gap-x-1">
        <div class="">
            <label>
                <input type="text"
                       class="w-full lg:w-64 rounded-md"
                       placeholder="search"
                       wire:model="searchTerm"
                >
            </label>
        </div>

        <div class="flex items-center rounded-md bg-slate-900 px-2 py-3 w-full grid grid-cols-3">
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
        <div class="text-right">
            <label>
                <select wire:model="recordCount"
                        class="w-full lg:w-64 rounded-md"
                >
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>
        </div>
        <div class="text-right">
            <label>
                <select wire:model="filter"
                        class="w-full lg:w-64 rounded-md"
                >
                    <option value="received">Received</option>
                    <option value="processed">Processed</option>
                    <option value="packed">Packed</option>
                    <option value="shipped">Shipped</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </label>
        </div>
    </div>

    <x-modal wire:model.defer="quickViewCustomerAccountModal">
        @if($selectedCustomerLatestTransactions)
            <div class="py-6">
                @forelse($selectedCustomerLatestTransactions as $transaction)
                    <div class="grid grid-cols-4 border-b py-0.5">
                        <div>
                            <p class="text-xs font-semibold"> {{ $transaction->id }} {{ strtoupper($transaction->type) }}</p>
                            <p class="text-xs text-slate-500">{{ $transaction->created_at }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold">{{ strtoupper($transaction->reference) }}</p>
                            <p class="text-xs text-slate-400">{{ $transaction->created_by }}</p>
                        </div>
                        <div class="text-right text-xs font-semibold">
                            <p>{{ number_format($transaction->amount,2) }}</p>
                        </div>
                        <div class="text-right text-xs font-semibold">
                            <p>{{ number_format($transaction->running_balance,2) }}</p>
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

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-5">
            <x-table.heading>Order #
                <button wire:click="$set('direction','asc')"
                        class="@if($direction === 'asc') text-green-600  @endif"
                >
                    &uparrow;
                </button>
                <button wire:click="$set('direction','desc')"
                        class="@if($direction === 'desc') text-green-600  @endif"
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
                <x-table.row class="text-center lg:text-left">
                    <a class="link"
                       href="{{ route('orders/show',$order->id) }}"
                    >{{ $order->number}}</a>
                    <div class="pt-1 flex justify-between">
                        <p class="text-xs">
                            {{ $order->created_at }}
                        </p>
                        @if($order->created_at->diffInDays(today()) > 0)
                            <p
                                @class([
                                    'rounded-l-full rounded-r-full px-1',
                                    'bg-yellow-500 text-yellow-100' => $order->created_at->diffInDays(today()) <= 3,
                                    'bg-red-800 text-red-100' => $order->created_at->diffInDays(today()) > 3,
                                ])
                            >{{ $order->created_at->diffInDays(today()) }}
                            </p>
                        @else
                            <div class="bg-green-800 rounded-l-full rounded-r-full px-2 flex items-center justify-center">
                                <p class="text-xs text-green-200 leading-0">
                                    new
                                </p>
                            </div>
                        @endif
                    </div>
                </x-table.row>
                <x-table.row class="">
                    <div class="flex lg:items-start justify-center lg:justify-between">
                        <div>
                            <a class="link"
                               href="{{ route('customers/show',$order->customer->id) }}"
                            >{{$order->customer->name}}</a>
                            <div class="pt-1 flex justify-between space-x-2">
                                <p
                                    @class([
                                        'text-xs',
                                        'text-pink-700 dark:text-pink-400' => $order->customer->type() === 'wholesale',
                                        'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                                    ])
                                >{{ $order->customer->type() }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $order->customer->salesperson->name ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <button wire:click.prefetch="quickViewCustomerAccount('{{$order->customer->id}}')">
                                <x-icons.view class="w-4 h-4 link"/>
                            </button>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    @php
                        $orderTotal = $order->getTotal()
                    @endphp
                    <p>R {{ number_format($order->delivery_charge,2) }}</p>
                    <p>
                        <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery->type ?? '' }}</p>
                    <p class="lg:hidden">
                        <span class="font-bold">Total:</span>R {{ number_format($orderTotal,2) }}
                    </p>
                </x-table.row>
                <x-table.row class="p-2 text-right hidden lg:block">
                    <p>R {{ number_format($orderTotal,2) }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right p-2">
                    @php
                        $transaction = $order->customer->transactions->where('reference','=',$order->number)->first();
                        $document = config('app.admin_url')."/storage/documents/{$transaction->uuid}.pdf";
                        $documentExists = check_file_exist($document)
                    @endphp
                    @if($documentExists)
                        <a href="{{$document}}"
                           class="link"
                        >
                            &darr; print
                        </a>
                    @else
                        <button class="link-alt"
                                wire:click="getDocument({{ $transaction->id }})"
                        >
                            request
                        </button>
                    @endif
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>

</div>
