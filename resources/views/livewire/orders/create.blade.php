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
                                       wire:model.defer="selectedProducts"
                                       wire:key="{{$product->id}}"
                                       value="{{$product->id}}"
                                       type="checkbox"
                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                            </div>
                            <div class="flex lg:justify-between ml-3 w-full items-center">
                                <x-product-listing-simple :product="$product"/>
                                <div>
                                    <p class="text-sm font-bold">
                                        R {{ number_format($product->getPrice($this->order->customer),2) }}</p>
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


        <form wire:submit.prevent="addAddress">
            <div class="py-1">
                <label for="address_line_one" class="block text-sm font-medium text-gray-700">
                    Address line one
                </label>
                <input type="text" id="address_line_one" wire:model.defer="line_one"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'line_one')
                <div class="py-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="address_line_two" class="block text-sm font-medium text-gray-700">
                    Address line two
                </label>
                <input type="text" id="address_line_two" wire:model.defer="line_two"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'line_two')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="suburb" class="block text-sm font-medium text-gray-700">
                    Suburb
                </label>
                <input type="text" id="suburb" wire:model.defer="suburb"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('suburb')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="city" class="block text-sm font-medium text-gray-700">
                    City
                </label>
                <input type="text" id="city" wire:model.defer="city"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('city')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                <select id="province" name="province" wire:model.defer="province"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    <option value="">Select a province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" class="capitalize">
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="postal_code" class="block text-sm font-medium text-gray-700">
                    Postal code
                </label>
                <input type="text" id="postal_code" wire:model.defer="postal_code"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('postal_code')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="pt-3">
                <button class="button-success">
                    add address
                </button>
            </div>
        </form>
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
        <x-table.header class="lg:grid grid-cols-4 hidden">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="lg:text-right">price</x-table.heading>
            <x-table.heading class="lg:text-right">qty</x-table.heading>
        </x-table.header>
        @if(!empty($selectedProductsToDelete))
            <div>
                <button class="text-xs text-red-400 hover:text-red-700"
                        x-on:click="@this.call('removeProducts')"
                >remove selected items
                </button>
            </div>
        @endif
        @foreach($this->order->items as $item)
            <x-table.body class="grid lg:grid-cols-4">
                <x-table.row class="col-span-2">
                    <div class="flex justify-start items-center">
                        <div>
                            <label for="{{$item->id}}" class="hidden"></label>
                            <input id="{{$item->id}}" aria-describedby="product"
                                   wire:model="selectedProductsToDelete"
                                   wire:key="{{$item->id}}"
                                   value="{{$item->id}}"
                                   type="checkbox"
                                   class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 text-xs">
                                {{ $item->product->sku }}
                            </p>
                            <p class="font-semibold text-gray-800 text-sm">
                                {{ $item->product->brand }} {{ $item->product->name }}
                            </p>
                            <div class="flex space-x-1 items-center">
                                @foreach($item->product->features as $feature)
                                    <p class="text-xs text-gray-600 pr-1 @if(!$loop->last) border-r @endif"
                                    > {{ $feature->name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    <form
                        x-on:keydown.tab="@this.call('updatePrice',{{$item->id}},$event.target.value)"
                        x-on:keydown.enter="@this.call('updatePrice',{{$item->id}},$event.target.value)"
                    >
                        <x-input type="number"
                                 value="{{ $item->price }}"
                                 pattern="[0-9]*"
                                 inputmode="numeric"
                                 step="0.01"
                                 label="price"/>
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
                    <form x-on:keydown.tab="@this.call('updateQty',{{$item->id}},$event.target.value)"
                          x-on:keydown.enter="@this.call('updateQty',{{$item->id}},$event.target.value)"
                    >
                        <x-input type="number" value="{{ $item->qty }}"
                                 label="qty"
                                 pattern="[0-9]*"
                                 inputmode="numeric"
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
