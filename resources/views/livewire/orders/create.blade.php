<div>
    <div class="w-full bg-white rounded-md p-6 mb-3 grid grid-cols-1 lg:grid-cols-3">
        <div>
            <p class="font-semibold">{{ $this->order->number }}</p>
            <p class="text-xs text-gray-500">{{ $this->order->updated_at }}</p>
            <p class="font-bold py-2">R {{ number_format($this->order->getTotal(),2)}}</p>
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
            @isset($this->order->address_type_id)
                <p class="py-2 capitalize">{{ $this->order->delivery?->type }}</p>
            @endisset
        </div>
    </div>

    <x-slide-over x-cloak wire:ignore.self="searchQuery" title="Select products"
                  wire:model.defer="showProductSelectorForm">
        <div>
            <x-input type="search" label="search products" wire:model="searchQuery"/>
        </div>

        <div class="pt-4">
            <form wire:submit.prevent="addProducts">
                <div class="py-6">
                    <button class="button-success">
                        <x-icons.plus class="w-5 h-5 mr-2"/>
                        add
                    </button>
                </div>
                <fieldset class="space-y-2">
                    @forelse($products as $product)
                        <label class="relative flex items-start bg-gray-100 py-2 px-4 rounded-md">
                            <div>
                                <input id="{{$product->id}}" aria-describedby="product"
                                       wire:model="selectedProducts"
                                       wire:key="{{$product->id}}"
                                       value="{{$product->id}}"
                                       type="checkbox"
                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                            </div>
                            <div class="flex justify-between ml-3 w-full items-center">
                                <div class="text-sm">
                                    <div for="{{$product->id}}"
                                         class="font-semibold text-gray-700">{{ $product->brand }} {{ $product->name }}</div>
                                    <div class="flex space-x-2 items-center">
                                        <p class="text-gray-700 text-xs">{{ $product->sku }}</p>
                                        @foreach($product->features as $feature)
                                            <p id="features" class="text-gray-500 text-xs">{{ $feature->name }}
                                                @if(!$loop->last) <span> | </span>@endif
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="rounded-full">
                                    <img src="{{ asset($product->image) }}" alt=""
                                         class="w-10 h-10 rounded-full">
                                </div>
                            </div>
                        </label>
                    @empty
                        <div
                            class="w-full bg-gray-100 rounded-md flex justify-center items-center inset-0 py-6 px-2 text-center">
                            <p>No results</p>
                        </div>
                    @endforelse
                </fieldset>
            </form>
        </div>
        <div class="py-3">
            {{ $products->links() }}
        </div>
    </x-slide-over>

    <x-modal title="Are your sure?" wire:model.defer="cancelConfirmation">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-danger" x-on:click="@this.call('cancel')">cancel order</button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?" wire:model.defer="showConfirmModal">
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success" x-on:click="@this.call('process')">
                process order
            </button>
        </div>
        <p class="text-gray-600 text-xs">This action is non reversible</p>
    </x-modal>


    <div wire:loading.class="hidden" wire:target="process"
         class="grid grid-cols-1 lg:grid-cols-5 space-y-2 lg:space-y-0 lg:space-x-2 py-2">
        <div>
            <button class="text-xs button-success w-full h-full"
                    x-on:click="@this.set('showProductSelectorForm',true)">
                <x-icons.plus class="w-5 h-5 mr-3"/>
                add products
            </button>
        </div>
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
                <x-icons.plus class="w-5 h-5 mr-3"/>
                cancel
            </button>
        </div>
        <div>
            @isset($this->order->delivery_type_id)
                @isset($this->order->address_id)
                    <button class="text-xs button-warning w-full h-full"
                            x-on:click="@this.set('showConfirmModal',true)"
                    >
                        <x-icons.plus class="w-5 h-5 mr-3"/>
                        place order
                    </button>
                @endisset
            @endisset
        </div>
    </div>

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
                </x-table.row>
                <x-table.row>
                    <form x-on:keydown.enter="@this.call('updateQty',{{$item->id}},$event.target.value)">
                        <x-input type="number" value="{{ $item->qty }}"
                                 x-on:keypress.prevent
                                 min="1"
                                 max="{{ $item->product->qty() }}"/>
                    </form>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500">{{ $item->product->qty() - $item->qty }} more available</p>
                        </div>
                        <div class="text-red-500 font-bold">
                            <button
                                x-on:click="@this.call('removeItem',{{$item->id}})"
                            >remove
                            </button>
                        </div>
                    </div>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>
</div>
