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


    <div class="hidden lg:flex justify-center items-center space-x-4 py-4 bg-white rounded-md">

        <button x-on:click="@this.set('filter','received')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'received')  border-green-600 @else border-transparent @endif">
            <x-icons.shopping-bag class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Received</p>
        </button>

        <button x-on:click="@this.set('filter','processed')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'processed')  border-green-600 @else border-transparent @endif">
            <x-icons.clipboard class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Processed</p>
        </button>

        <button x-on:click="@this.set('filter','packed')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'packed')  border-green-600 @else border-transparent @endif">
            <x-icons.products class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Packed</p>
        </button>

        <button x-on:click="@this.set('filter','shipped')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'shipped')  border-green-600 @else border-transparent @endif">
            <x-icons.truck class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Shipped</p>
        </button>

        <button x-on:click="@this.set('filter','completed')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'completed')  border-green-600 @else border-transparent @endif">
            <x-icons.tick class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Completed</p>
        </button>

        <button x-on:click="@this.set('filter','cancelled')"
                class="flex items-end justify-end space-x-2 hover:border-gray-300 border-b pb-2 @if($filter == 'cancelled')  border-green-600 @else border-transparent @endif">
            <x-icons.cross class="w-5 h-5 text-green-600"/>
            <p class="text-sm font-semibold">Cancelled</p>
        </button>

    </div>

    <div class="w-full text-center flex justify-center py-3">
        <x-inputs.search wire:model="searchTerm"/>
    </div>

    <div class="flex justify-center items-center lg:hidden pt-3">
        <x-select wire:model="filter" label="Select a status">
            <option value="received">Received</option>
            <option value="processed">Processed</option>
            <option value="packed">Packed</option>
            <option value="shipped">Shipped</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </x-select>
    </div>

    <div class="py-2">
        {{ $orders->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-6">
            <x-table.heading>Order #
                <button wire:click="$set('direction','asc')" class="@if($direction === 'asc') text-green-600  @endif">
                    &uparrow;
                </button>
                <button wire:click="$set('direction','desc')" class="@if($direction === 'desc') text-green-600  @endif">
                    &downarrow;
                </button>
            </x-table.heading>
            <x-table.heading>customer</x-table.heading>
            <x-table.heading class="text-center">status</x-table.heading>
            <x-table.heading class="text-center">delivery</x-table.heading>
            <x-table.heading class="text-right">total</x-table.heading>
            <x-table.heading class="text-right">invoice</x-table.heading>
        </x-table.header>
        @forelse($orders as $order)
            <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
                <x-table.row class="text-center lg:text-left">
                    <a class="link"
                       href="{{ route('orders/show',$order->id) }}">{{ $order->number}}</a>
                    <div class="pt-1">
                        <p class="text-xs">{{ $order->placed_at ?? $order->created_at }}</p>
                    </div>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <a class="link"
                       href="{{ route('customers/show',$order->customer->id) }}">{{$order->customer->name}}</a>
                </x-table.row>
                <x-table.row>
                    <div class="w-full flex justify-center items-center">
                        @if($order->status == 'received')
                            <x-icons.shopping-bag class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'processed')
                            <x-icons.clipboard class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'packed')
                            <x-icons.products class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'shipped')
                            <x-icons.truck class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'completed')
                            <x-icons.tick class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'cancelled')
                            <x-icons.cross class="w-5 h-5 text-red-600"/>
                        @endif
                    </div>
                </x-table.row>
                <x-table.row class="text-center">
                    @php
                        $orderTotal = $order->total
                    @endphp
                    <p>
                        <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery->type ?? '' }}</p>
                    <p class="lg:hidden">
                        <span class="font-bold">Total:</span>R {{ number_format($orderTotal,2) }}
                    </p>
                </x-table.row>
                <x-table.row class="p-2 text-right hidden lg:block">
                    <p class="text-gray-900">R {{ number_format($orderTotal,2) }}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right p-2">
                    @php
                        $transaction = $order->customer->transactions->where('reference','=',$order->number)->first();
                        $document = config('app.admin_url')."/storage/documents/{$transaction->uuid}.pdf";
                        $documentExists = check_file_exist($document)
                    @endphp
                    @if($documentExists)
                        <a href="{{$document}}" class="link">
                            &darr; print
                        </a>
                    @else
                        <button class="link" wire:click="getDocument({{ $transaction->id }})">
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
