<div>
    <div class="w-full bg-white rounded-md p-6 mb-3 grid grid-cols-1 lg:grid-cols-3">
        <div>
            <p class="font-semibold">{{ $this->order->number }}</p>
            <p class="text-xs text-gray-500">{{ $this->order->updated_at }}</p>
            <p class="font-bold py-2">R {{ number_format($this->order->getTotal(),2)}}</p>
            <p class="font-bold text-xs pt-2">
                Processed By:
            </p>
            <p class="font-bold text-xs pb-2">
                {{ $this->order->processed_by}}
            </p>
        </div>

        <div>
            <p class="font-semibold">{{ $this->order->customer->name }}
                @isset($this->order->customer->company)
                    <span>| {{ $this->order->customer->company}}</span>
                @endisset
            </p>
            @isset($this->order->address_id)
                <div class="text-xs capitalize font-semibold">
                    <p>{{$this->order->address->line_one }}</p>
                    <p>{{ $this->order->address->line_two }}</p>
                    <p>{{ $this->order->address->suburb }}, {{ $this->order->address->city }},</p>
                    <p>{{ $this->order->address->province }}, {{ $this->order->address->postal_code }}</p>
                </div>
            @endisset
            @isset($this->order->delivery_type_id)
                <p class="py-2 capitalize">{{ $this->order->delivery->type }}</p>
            @endisset
        </div>
        @if($this->order->status == 'cancelled')
            <div>
                <h1 class="text-3xl font-extrabold text-red-700">CANCELLED</h1>
            </div>
        @endif
        @if($this->order->status == 'received')
            <div class="text-right">
                <button class="button-success"
                        x-on:click="@this.call('pushToWarehouse')"
                >push to warehouse
                </button>

                <div class="pt-4">
                    <button class="text-red-400 hover:text-red-700" x-on:click="@this.set('cancelConfirmation',true)">
                        cancel
                    </button>
                </div>
            </div>
        @endif
    </div>

    <x-modal title="Are your sure?" wire:model.defer="cancelConfirmation">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-danger" x-on:click="@this.call('cancel')">cancel order</button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-table.container>
        <x-table.header class="grid grid-cols-4">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="lg:text-right">price</x-table.heading>
            <x-table.heading class="lg:text-right">qty</x-table.heading>
        </x-table.header>
        @foreach($this->order->items as $item)
            <x-table.body class="grid grid-cols-4">
                <x-table.row class="col-span-2">
                    <p class="text-xs">{{ $item->product->sku }}</p>
                    <p class="text-sm font-semibold">{{ $item->product->brand }} {{ $item->product->name }}</p>
                    <div class="flex flex-wrap">
                        @foreach($item->product->features as $feature)
                            <p class="text-sm font-semibold text-xs border-r pr-1 @if(!$loop->first) pl-1 @endif ">
                                {{ $feature->name }}
                            </p>
                        @endforeach
                    </div>
                </x-table.row>
                <x-table.row>
                    @if($this->order->status == 'received')
                        <form
                            x-on:keydown.enter="@this.call('updatePrice',{{$item->id}},$event.target.value)">
                            <x-input type="number" value="{{ $item->price }}" step="0.01"/>
                        </form>
                        @hasPermissionTo('view cost')
                        <div class="flex justify-between items-center pt-1">
                            <div>
                                <p class="text-xs
                                @if( profit_percentage($item->price, $item->product->cost) < 0) text-red-700 @else text-green-500 @endif">
                                    {{  profit_percentage($item->price, $item->product->cost) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">
                                    R {{ $item->product->cost }}
                                </p>
                            </div>
                        </div>
                        @endhasPermissionTo
                    @else
                        <div class="text-right">
                            R {{ number_format($item->price,2) }}
                        </div>
                    @endif
                </x-table.row>
                <x-table.row>
                    @if($this->order->status == 'received')
                        <form x-on:keydown.enter="@this.call('updateQty',{{$item->id}},$event.target.value)">
                            <x-input type="number" value="{{ $item->qty }}"
                                     x-on:keypress.prevent
                                     min="1"
                                     max="{{ $item->product->qty() + $item->qty  }}"/>
                        </form>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500">{{ $item->product->qty() }} more available</p>
                            </div>
                            <div class="text-red-500 font-bold">
                                <button
                                    x-on:click="@this.call('removeItem',{{$item->id}})"
                                >remove
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="text-right">
                            {{ $item->qty }}
                        </div>
                    @endif
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>
</div>
