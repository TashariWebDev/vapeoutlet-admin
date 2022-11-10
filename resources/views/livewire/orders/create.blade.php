<div class="relative">
    <div class="grid grid-cols-1 gap-3 p-6 mb-3 w-full bg-white rounded-md lg:grid-cols-2 dark:bg-slate-900">
        <div>
            <p class="font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->number }}</p>
            <p class="text-xs text-slate-500">{{ $this->order->updated_at }}</p>
            <div class="flex justify-between p-2 mt-2 rounded bg-slate-200 dark:bg-slate-800">
                <p class="text-sm font-bold text-slate-600 dark:text-slate-400">
                    Total: R {{ number_format($this->order->getTotal(), 2) }}
                </p>
                <p class="text-sm font-bold text-slate-600 dark:text-slate-400">
                    Count: {{ $this->order->items->count() }}
                </p>
            </div>
        </div>

        <div>
            <p class="font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->customer->name }}
                @isset($this->order->customer->company)
                    <span>| {{ $this->order->customer->company }}</span>
                @endisset
            </p>
            @isset($this->order->address_id)
                <div class="text-xs font-semibold capitalize text-slate-600 dark:text-slate-400">
                    <p>{{ $this->order->address->line_one }}</p>
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

    <x-slide-over
        title="Select products"
        x-cloak
        wire:ignore.self="searchQuery"
        wire:model.defer="showProductSelectorForm"
    >
        <div x-data="{ searchQuery: @entangle('searchQuery') }">
            <div class="relative">
                <label>
                    <input
                        class="w-full rounded-md border-2 border-yellow-400 focus:ring-2 placeholder-slate-300"
                        type="search"
                        x-model.lazy="searchQuery"
                        placeholder="search"
                    >
                </label>
                <div
                    class="absolute top-0 right-0 w-2 h-2 bg-green-600 rounded-full ring-1 ring-blue-400 ring-offset-1 animate-ping"
                    wire:loading="updatedSearchQuery"
                >

                </div>
            </div>
            @if (count($products))
                <div class="p-1">
                    <p class="text-xs font-semibold uppercase"> {{ count($products) }} results</p>
                </div>
            @endif
        </div>

        <div class="pt-4">
            <form wire:submit.prevent="addProducts">
                <div class="py-6">
                    <button class="w-full button-success">
                        <x-icons.plus class="mr-2 w-5 h-5" />
                        add
                    </button>
                </div>
                <fieldset class="space-y-2">
                    @forelse($this->products as $product)
                        <label
                            class="flex relative items-start py-2 px-4 rounded-md bg-slate-100"
                            wire:key="'item-'{{ $product->id }}"
                        >
                            <div>
                                <input
                                    class="w-4 h-4 text-green-600 rounded focus:ring-green-500 border-slate-300"
                                    id="{{ $product->id }}"
                                    type="checkbox"
                                    value="{{ $product->id }}"
                                    aria-describedby="product"
                                    wire:model.defer="selectedProducts"
                                >
                            </div>
                            <div class="flex items-center ml-3 w-full lg:justify-between">
                                <x-product-listing-simple :product="$product" />
                                <div>
                                    <p class="text-sm font-bold">
                                        R {{ number_format($product->getPrice($this->order->customer), 2) }}
                                    </p>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div
                            class="flex inset-0 justify-center items-center py-6 px-2 w-full text-center rounded-md bg-slate-100">
                            <p>No results</p>
                        </div>
                    @endforelse
                </fieldset>
            </form>
        </div>
    </x-slide-over>

    <x-modal
        title="Are your sure?"
        wire:model.defer="cancelConfirmation"
    >
        <div class="flex items-center py-3 space-x-2">
            <button
                class="button-danger"
                wire:loading.attr="disabled"
                wire:click="credit"
            >
                <span
                    class="pr-2"
                    wire:target="credit"
                    wire:loading
                ><x-icons.refresh class="w-3 h-3 text-slate-300 animate-spin-slow" /></span>
                credit this order
            </button>
        </div>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <x-modal
        title="Are your sure?"
        wire:model.defer="showConfirmModal"
    >
        <div class="flex items-center py-3 space-x-2">
            <button
                class="disabled:opacity-25 button-success"
                wire:click="process"
                wire:target="process"
                wire:loading.attr="disabled"
            >
                <span
                    class="pr-2"
                    wire:loading
                ><x-icons.refresh class="w-3 h-3 text-slate-300 animate-spin-slow" /></span>
                process order
            </button>
        </div>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <div
        class="grid grid-cols-1 py-2 px-2 space-y-2 lg:grid-cols-5 lg:px-0 lg:space-y-0 lg:space-x-2"
        wire:loading.class="hidden"
        wire:target="process"
    >
        <div>
            <button
                class="w-full h-full text-xs button-success"
                x-on:click="@this.set('showProductSelectorForm',true)"
            >
                <x-icons.plus class="mr-3 w-5 h-5" />
                add products
            </button>
        </div>
        <div>
            <button
                class="w-full h-full text-xs button-success"
                x-on:click="@this.set('chooseAddressForm',true)"
            >
                <x-icons.plus class="mr-3 w-5 h-5" />
                billing address
            </button>
        </div>
        <div>
            <button
                class="w-full h-full text-xs button-success"
                @if ($this->order->address_id === null) disabled @endif
                x-on:click="@this.set('chooseDeliveryForm',true)"
            >
                <x-icons.plus class="mr-3 w-5 h-5" />
                delivery option
            </button>
        </div>
        <div>
            <button
                class="w-full h-full text-xs button-danger"
                x-on:click="@this.set('cancelConfirmation',true)"
            >
                <x-icons.plus class="mr-3 w-5 h-5" />
                Credit this invoice
            </button>
        </div>
        <div>
            @isset($this->order->delivery_type_id)
                @if ($this->order->items->count() > 0)
                    <div>
                        @isset($this->order->address_id)
                            <button
                                class="w-full h-full text-xs button-warning"
                                wire:target="process"
                                wire:loading.attr="disabled"
                                x-on:click="@this.set('showConfirmModal',true)"
                            >
                                <x-icons.plus class="mr-3 w-5 h-5" />
                                place order
                            </button>
                        @endisset
                    </div>
                @endif
            @endisset
        </div>
    </div>

    <x-modal
        title="select an address"
        wire:model.defer="chooseAddressForm"
    >
        <label>
            <select
                class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                x-on:change="@this.call('updateAddress',$event.target.value)"
            >
                <option value="">Choose</option>
                @foreach ($this->order->customer->addresses as $address)
                    <option
                        class="capitalize"
                        value="{{ $address->id }}"
                    >
                        {{ $address->line_one }}
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
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="address_line_one"
                >
                    Address line one
                </label>
                <input
                    class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                    id="address_line_one"
                    type="text"
                    wire:model.defer="line_one"
                >
                @error('line_one')
                    <div class="py-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="py-1">
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="address_line_two"
                >
                    Address line two
                </label>
                <input
                    class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                    id="address_line_two"
                    type="text"
                    wire:model.defer="line_two"
                >
                @error('line_two')
                    <div class="pt-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="py-1">
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="suburb"
                >
                    Suburb
                </label>
                <input
                    class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                    id="suburb"
                    type="text"
                    wire:model.defer="suburb"
                >
                @error('suburb')
                    <div class="pt-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="py-1">
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="city"
                >
                    City
                </label>
                <input
                    class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                    id="city"
                    type="text"
                    wire:model.defer="city"
                >
                @error('city')
                    <div class="pt-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="py-1">
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="province"
                >Province</label>
                <select
                    class="w-full rounded-md shadow-sm sm:text-sm focus:border-yellow-500 focus:ring-yellow-500 border-slate-300"
                    id="province"
                    name="province"
                    wire:model.defer="province"
                >
                    <option value="">Select a province</option>
                    @foreach ($provinces as $province)
                        <option
                            class="capitalize"
                            value="{{ $province }}"
                        >
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                    <div class="pt-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="py-1">
                <label
                    class="block text-sm font-medium text-slate-700"
                    for="postal_code"
                >
                    Postal code
                </label>
                <input
                    class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                    id="postal_code"
                    type="text"
                    wire:model.defer="postal_code"
                >
                @error('postal_code')
                    <div class="pt-1">
                        <p class="text-xs text-red-700 uppercase">{{ $message }}</p>
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

    <x-modal
        title="select an delivery option"
        wire:model.defer="chooseDeliveryForm"
    >
        <label>
            <select
                class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300"
                x-on:change="@this.call('updateDelivery',$event.target.value)"
            >
                <option value="">Choose</option>
                @foreach ($deliveryOptions as $delivery)
                    <option
                        class="capitalize"
                        value="{{ $delivery->id }}"
                    >
                        {{ $delivery->type }}
                        {{ number_format($delivery->price, 2) }}
                    </option>
                @endforeach
            </select>
        </label>
    </x-modal>

    <x-table.container>
        <x-table.header class="hidden grid-cols-6 lg:grid">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="lg:text-right">price</x-table.heading>
            <x-table.heading class="lg:text-right">discount</x-table.heading>
            <x-table.heading class="lg:text-right">qty</x-table.heading>
            <x-table.heading class="lg:text-right">Line total</x-table.heading>
        </x-table.header>
        <div>
            @if (!empty($selectedProductsToDelete))
                <div>
                    <button
                        class="text-xs text-red-700 dark:text-red-400 hover:text-red-700"
                        x-on:click="@this.call('removeProducts')"
                    >remove selected items
                    </button>
                </div>
            @endif
        </div>
        @foreach ($this->order->items as $item)
            <x-table.body
                class="grid lg:grid-cols-6"
                wire:key="'item-table-'{{ $item->id }}"
            >
                <x-table.row class="col-span-2">
                    <div class="flex justify-start items-center">
                        <div>
                            <label
                                class="hidden"
                                for="{{ $item->id }}"
                            ></label>
                            <input
                                class="w-4 h-4 text-green-600 rounded focus:ring-green-500 border-slate-300"
                                id="{{ $item->id }}"
                                type="checkbox"
                                value="{{ $item->id }}"
                                aria-describedby="product"
                                wire:model="selectedProductsToDelete"
                            >
                        </div>
                        <div>
                            <x-product-listing-simple
                                :product="$item->product"
                                wire:key="'order-item-'{{ $item->id }}"
                            />
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    @hasPermissionTo('edit pricing')
                        <form
                            x-on:keydown.tab="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                            x-on:keydown.enter="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                        >
                            <label>
                                <input
                                    class="w-full rounded-md text-slate-700"
                                    type="number"
                                    value="{{ $item->price }}"
                                    pattern="[0-9]*"
                                    inputmode="numeric"
                                    step="0.01"
                                />
                            </label>
                        </form>
                    @endhasPermissionTo
                    <div>
                        @hasPermissionTo('view cost')
                            <div class="flex justify-between items-center pt-1">
                                <div>
                                    <p
                                        class="@if (profit_percentage($item->price, $item->product->cost) < 0) text-red-700 @else text-green-500 @endif text-xs">
                                        {{ profit_percentage($item->price, $item->product->cost) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">
                                        R {{ $item->product->cost }}
                                    </p>
                                </div>
                            </div>
                        @endhasPermissionTo
                    </div>
                </x-table.row>
                <x-table.row>
                    <label>
                        <input
                            class="w-full rounded-md text-slate-700 bg-slate-400"
                            type="number"
                            value="{{ $item->discount }}"
                            disabled
                        />
                    </label>
                </x-table.row>
                <x-table.row>
                    <form
                        x-on:keydown.tab="@this.call('updateQty',{{ $item->id }},$event.target.value)"
                        x-on:keydown.enter="@this.call('updateQty',{{ $item->id }},$event.target.value)"
                    >
                        <label>
                            <input
                                class="w-full rounded-md text-slate-700"
                                type="number"
                                value="{{ $item->qty }}"
                                pattern="[0-9]*"
                                inputmode="numeric"
                                min="1"
                                max="{{ $item->product->qty() + (0 - $item->stock()->first()?->qty) }}"
                            />
                        </label>
                    </form>
                    <div class="flex justify-between items-center mt-1">
                        <div>
                            <p class="text-xs text-slate-500">
                                {{ $item->product->qty() - $item->qty + (0 - $item->stock()->first()?->qty) }}
                                more
                                available</p>
                        </div>
                        <div class="text-xs text-red-700 dark:text-red-400 hover:text-red-700">
                            <button
                                wire:loading.attr="disabled"
                                wire:target="removeProducts"
                                wire:click="removeItem({{ $item->id }})"
                            >remove
                            </button>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    <label>
                        <input
                            class="w-full rounded-md text-slate-700 bg-slate-400"
                            type="number"
                            value="{{ $item->line_total }}"
                            disabled
                        />
                    </label>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>
</div>
