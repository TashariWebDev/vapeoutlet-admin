<div class="relative">

    <x-modal x-data="{ show: $wire.entangle('chooseAddressForm') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Select address</h3>
        </div>

        <form wire:submit.prevent="updateAddress">
            <x-input.label for="address_id">
                Address
            </x-input.label>
            <x-input.select
                id="address_id"
                wire:model.defer="addressId"
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
            </x-input.select>
            <div class="py-2">
                <button
                    class="button-success"
                    wire:loading.attr="disabled"
                    wire:target="updateAddress"
                >
                    <x-icons.busy target="updateAddress" />
                    update
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal x-data="{ show: $wire.entangle('chooseDeliveryForm') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Select an option</h3>
        </div>

        <form wire:submit.prevent="updateDelivery">
            <x-input.label for="updateDelivery">
                Delivery options
            </x-input.label>
            <x-input.select
                id="updateDelivery"
                wire:model.defer="deliveryId"
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
            </x-input.select>
            <div class="py-2">
                <button
                    class="button-success"
                    wire:loading.attr="disabled"
                    wire:target="updateDelivery"
                >
                    <x-icons.busy target="updateDelivery" />
                    update
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Process this order?</h3>
        </div>
        <div class="flex items-center py-3 space-x-2">
            <button
                class="w-32 button-success"
                wire:click="process"
                wire:target="process"
                wire:loading.attr="disabled"
            >
                <span
                    class="pr-2"
                    wire:loading
                ><x-icons.busy target="process" /></span>
                Yes!
            </button>
            <button
                class="w-32 button-danger"
                wire:loading.class="hidden"
                wire:target="process"
                x-on:click="show = !show"
            >
                No
            </button>
        </div>
        <p
            class="text-xs text-rose-600"
            wire:loading
            wire:target="process"
        >Processing...Do not close this page.</p>
        <p class="text-xs text-rose-600">This action is non reversible</p>
    </x-modal>

    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-2 p-2 lg:grid-cols-4">
            <div>
                <p class="text-xs font-bold uppercase text-slate-500 dark:text-sky-400">
                    {{ $this->order->number }} ( {{ $this->order->sales_channel->name }} )
                </p>
                <p class="text-xs text-slate-600 dark:text-slate-500">{{ $this->order->updated_at }}</p>
                @isset($this->order->delivery_type_id)
                    <p class="text-xs capitalize text-slate-600 dark:text-slate-500">{{ $this->order->delivery?->type }}
                    </p>
                @endisset
                <div class="flex justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Total: R {{ number_format($this->order->getTotal(), 2) }}
                        <span class="pl-3">(Delivery:{{ number_format($this->order->delivery_charge, 2) }})</span>
                    </p>
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Count: {{ $this->order->items_count }}
                    </p>
                </div>
            </div>
            <div>
                <p class="font-semibold text-sky-500 dark:text-sky-400">{{ $this->order->customer->name }}
                    @isset($this->order->customer->company)
                        <span>| {{ $this->order->customer->company }}</span>
                    @endisset
                </p>
                @isset($this->order->address_id)
                    <div class="text-xs font-semibold capitalize text-sky-500 dark:text-sky-400">
                        <p>{{ $this->order->address?->line_one }}</p>
                        <p>{{ $this->order->address?->line_two }}</p>
                        <p>{{ $this->order->address?->suburb }}, {{ $this->order->address?->city }},</p>
                        <p>{{ $this->order->address?->province }}, {{ $this->order->address?->postal_code }}</p>
                    </div>
                @endisset
            </div>

            <div class="grid grid-cols-2 gap-2 lg:grid-cols-3 lg:col-span-2">
                <div>
                    <button
                        class="w-full text-xs button-success"
                        @if ($this->order->customer->addresses->count() === 0) disabled @endif
                        x-on:click="$wire.set('chooseAddressForm',true)"
                    >
                        billing address
                    </button>
                </div>
                <div>
                    <button
                        class="w-full text-xs button-success"
                        @if ($this->order->address_id === null) disabled @endif
                        x-on:click="$wire.set('chooseDeliveryForm',true)"
                    >
                        delivery option
                    </button>
                </div>
                <div>
                    <livewire:address.create customer-id="{{ $this->order->customer_id }}" />
                </div>
                <div>
                    <livewire:orders.add-product :order="$this->order" />
                </div>
                <div>
                    <livewire:orders.cancel :order="$this->order" />
                </div>
                <div>
                    @isset($this->order->delivery_type_id)
                        @if ($this->order->items_count > 0)
                            <div>
                                @isset($this->order->address_id)
                                    <button
                                        class="w-full text-xs button-warning"
                                        wire:target="process"
                                        wire:loading.attr="disabled"
                                        x-on:click="$wire.set('showConfirmModal',true)"
                                    >
                                        place order
                                    </button>
                                @endisset
                            </div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>

        <div class="py-0.5 px-2 w-full">
            <div>
                <x-input.text
                    type="text"
                    placeholder="SKU"
                    autofocus
                    wire:model="sku"
                >
                </x-input.text>
            </div>
        </div>

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
                            class="text-xs text-rose-700 dark:text-rose-400 hover:text-rose-700"
                            x-on:click="$wire.call('removeProducts')"
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
                                    class="w-4 h-4 rounded text-sky-600 border-slate-300 focus:ring-sky-500"
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
                            <form>
                                <label>
                                    <x-input.text
                                        type="number"
                                        value="{{ $item->price }}"
                                        wire:keyup.debounce.500ms="updatePrice({{ $item->id }},$event.target.value)"
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
                                            class="@if (profit_percentage($item->price, $item->product->cost) < 0) text-rose-700 @else text-sky-500 @endif text-xs">
                                            {{ profit_percentage($item->price, $item->product->cost) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-600 dark:text-slate-500">
                                            R {{ $item->product->cost }}
                                        </p>
                                    </div>
                                </div>
                            @endhasPermissionTo
                        </div>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->discount }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>

                    <x-table.row>
                        <form>
                            <label>
                                <x-input.text
                                    type="number"
                                    value="{{ $item->qty }}"
                                    wire:keyup.debounce.500ms="updateQty({{ $item->id }},$event.target.value)"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    min="1"
                                    max="{{ $item->product->total_available }}"
                                />
                            </label>
                        </form>
                        <div class="flex justify-between items-center mt-1">
                            <div class="text-xs text-rose-700 dark:text-rose-400 hover:text-rose-700">
                                <button
                                    wire:loading.attr="disabled"
                                    wire:target="removeProducts"
                                    wire:click="removeItem({{ $item->id }})"
                                >remove
                                </button>
                            </div>
                            <div>
                                {{ $item->product->total_available }} in stock
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->line_total }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
