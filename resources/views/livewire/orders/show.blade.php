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
            @isset($this->order?->delivery_type_id)
                <p class="py-2 capitalize">{{ $this->order?->delivery->type }}</p>
            @endisset
        </div>
        @if($this->order->status == 'cancelled')
            <div>
                <h1 class="text-3xl font-extrabold text-red-700">CANCELLED</h1>
            </div>
        @endif
        @if($this->order->status == 'shipped')
            <div>
                <button class="button-success"
                        x-on:click="@this.call('pushToComplete')"
                >Complete order
                </button>
            </div>
        @endif
    </div>


    <x-modal title="Are your sure?" wire:model.defer="cancelConfirmation">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-danger" x-on:click="@this.call('cancel')">cancel order</button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?" wire:model.defer="showEditModal">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success" x-on:click="@this.call('edit')">
                edit order
            </button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?" wire:model.defer="showConfirmModal">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success" x-on:click="@this.call('pushToWarehouse')">
                process order
            </button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="select an address" wire:model.defer="chooseAddressForm">
        <label>
            <select x-on:change="@this.call('updateAddress',$event.target.value)"
                    class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">Choose</option>
                @foreach($this->order->customer->addresses as $address)
                    <option value="{{$address->id}}" class="capitalize">
                        {{$address->line_one }}
                        {{ $address->line_two }}
                        {{ $address->suburb }},
                        {{ $address->city }},
                        {{ $address->province }},
                        {{ $address->postal_code }}
                    </option>
                @endforeach
            </select>
        </label>
    </x-modal>

    <x-modal title="select an delivery option" wire:model.defer="chooseDeliveryForm">
        <label>
            <select x-on:change="@this.call('updateDelivery',$event.target.value)"
                    class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">Choose</option>
                @foreach($deliveryOptions as $delivery)
                    <option value="{{$delivery->id}}" class="capitalize">
                        {{$delivery->description }}
                        {{ number_format($delivery->price,2) }}
                    </option>
                @endforeach
            </select>
        </label>
    </x-modal>

    @if($this->order->status == 'received' && $this->order->items->count() > 0)
        <div wire:loading.class="hidden" wire:target="pushToWarehouse"
             class="grid grid-cols-1 lg:grid-cols-5 space-y-2 lg:space-y-0 lg:space-x-2 py-2">
            <div>
                <button class="text-xs button-success w-full h-full"
                        x-on:click="@this.set('chooseDeliveryForm',true)">
                    <x-icons.plus class="w-5 h-5 mr-3"/>
                    delivery option
                </button>
            </div>
            <div>
                <button class="text-xs button-success w-full h-full"
                        x-on:click="@this.set('chooseAddressForm',true)">
                    <x-icons.plus class="w-5 h-5 mr-3"/>
                    billing address
                </button>
            </div>
            <div>
                <button class="text-xs button-danger w-full h-full"
                        x-on:click="@this.set('cancelConfirmation',true)">
                    <x-icons.cross class="w-5 h-5 mr-3"/>
                    cancel
                </button>
            </div>
            <div>
                <button class="text-xs button-warning w-full h-full"
                        x-on:click="@this.set('showEditModal',true)"
                >
                    <x-icons.edit class="w-5 h-5 mr-3"/>
                    edit
                </button>
            </div>
            <div>
                <button class="text-xs button-warning w-full h-full"
                        x-on:click="@this.set('showConfirmModal',true)"
                >
                    <x-icons.warehouse class="w-5 h-5 mr-3"/>
                    push to warehouse
                </button>
            </div>
        </div>
    @endif

    <x-table.container>
        <x-table.header class="grid grid-cols-4">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="lg:text-right">price</x-table.heading>
            <x-table.heading class="lg:text-right">qty</x-table.heading>
        </x-table.header>
        @foreach($this->order->items as $item)
            <x-table.body class="grid grid-cols-4">
                <x-table.row class="col-span-2">
                    <div class="flex justify-start items-center">
                        <div>
                            <p class="text-xs">{{ $item->product->sku }}</p>
                            <p class="text-sm font-semibold">{{ $item->product->brand }} {{ $item->product->name }}</p>
                            <div class="flex flex-wrap">
                                @foreach($item->product->features as $feature)
                                    <p class="text-sm font-semibold text-xs border-r pr-1 @if(!$loop->first) pl-1 @endif ">
                                        {{ $feature->name }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right">
                        R {{ number_format($item->price,2) }}
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right">
                        {{ $item->qty }}
                    </div>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>
</div>
