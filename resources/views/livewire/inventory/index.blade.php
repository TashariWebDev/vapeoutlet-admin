<div>

    <x-slide-over wire:model.defer="showPurchaseCreateForm" title="New purchase"
    >
        <form wire:submit.prevent="save">
            <div class="py-6 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showSuppliersCreateForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select wire:model.defer="selectedSupplier" label="Select a supplier">
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-4">
                <x-input type="date" wire:model.defer="date" label="Invoice date"/>
            </div>
            <div class="py-4">
                <x-input type="text" wire:model.defer="invoice_no" label="Invoice number"/>
            </div>
            <div class="py-4">
                <x-select wire:model.defer="currency"
                          label="Select a currency">
                    <option value="ZAR">ZAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="CNH">CNH</option>
                </x-select>
            </div>
            <div class="py-4">
                <x-input-number type="number" wire:model.defer="exchange_rate" placeholder="optional"
                                label="Exchange rate in ZAR"/>
            </div>
            <div class="py-4">
                <x-input-number type="number" wire:model.defer="amount"
                                label="Invoice amount in selected currency (ex shipping)"/>
            </div>
            <div class="py-4">
                <x-input-number type="number" wire:model.defer="shipping_rate"
                                label="Shipping rate as %"/>
            </div>
            <div class="py-4">
                <button class="button-success">
                    <x-icons.save class="w-5 h-5 mr-2"/>
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <x-modal title="Manage suppliers" wire:model.defer="showSuppliersCreateForm">
        <div>
            <form wire:submit.prevent="addSupplier">
                <div class="py-2">
                    <x-input type="text" label="Name" wire:model.defer="name"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Email" wire:model.defer="email"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Phone" wire:model.defer="phone"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Contact person" wire:model.defer="person"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Address line one" wire:model.defer="address_line_one"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Address line one" wire:model.defer="address_line_two"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Suburb" wire:model.defer="suburb"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="City" wire:model.defer="city"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Country" wire:model.defer="country"/>
                </div>

                <div class="py-2">
                    <x-input type="text" label="Postal code" wire:model.defer="postal_code"/>
                </div>

                <div class="py-2">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>


    <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 px-2 md:px-0">
        <div class="lg:col-span-2">
            <x-inputs.search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full">
            <button class="button-success w-full"
                    x-on:click="$wire.set('showPurchaseCreateForm',true)"
            >
                <x-icons.plus class="w-5 w-5 mr-2"/>
                new purchase
            </button>
        </div>

        <div>
            <a href="{{ route('suppliers') }}" class="button-success w-full">
                <x-icons.users class="w-5 w-5 mr-2"/>
                suppliers
            </a>
        </div>
    </div>

    {{--    @json($products)--}}

    <div class="py-3">
        {{ $products->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid grid-cols-1 md:grid-cols-10">
            <x-table.heading class="col-span-2">product</x-table.heading>
            <x-table.heading class="text-center">retail</x-table.heading>
            <x-table.heading class="text-center">wholesale</x-table.heading>
            <x-table.heading class="text-center">ave cost</x-table.heading>
            <x-table.heading class="text-center">last cost</x-table.heading>
            <x-table.heading class="text-center">purchased</x-table.heading>
            <x-table.heading class="text-center">returns</x-table.heading>
            <x-table.heading class="text-center">sold</x-table.heading>
            <x-table.heading class="text-center">available</x-table.heading>
        </x-table.header>
        @forelse($products as $product)
            <x-table.body
                class="grid grid-cols-1 md:grid-cols-10 text-sm">
                <x-table.row class="lg:col-span-2 text-center lg:text-left">
                    <p class="text-xs">{{ $product->sku }}</p>
                    <p>
                        <span
                            class="text-sm font-bold @if(!$product->is_active) text-red-700 @endif">{{ $product->brand }} {{ $product->name }}</span>
                        @if($product->trashed())
                            <span class="text-xs text-red-600"> (discontinued) </span>
                        @endif
                    </p>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start">
                        @foreach($product->features as $feature)
                            <p class="text-xs text-gray-600 px-1 border-r"
                            > {{ $feature->name }}</p>
                        @endforeach
                    </div>
                </x-table.row>
                <x-table.row>
                    <label>
                        <input type="number"
                               value="{{ $product->retail_price }}"
                               label="retail"
                               inputmode="numeric"
                               pattern="[0-9]"
                               class="w-full border rounded px-0.5"
                               @keydown.tab="@this.call('updateRetailPrice',{{$product->id}},$event.target.value)"/>
                    </label>
                    <span class="text-xs
                            @if( profit_percentage($product->retail_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif">
                            {{ profit_percentage($product->retail_price,$product->cost) }}
                    </span>
                </x-table.row>
                <x-table.row>
                    <label>
                        <input type="number"
                               value="{{ $product->wholesale_price }}"
                               label="wholesale"
                               inputmode="numeric"
                               pattern="[0-9]"
                               class="w-full border rounded px-0.5"
                               @keydown.tab="@this.call('updateWholesalePrice',{{$product->id}},$event.target.value)"
                        />
                    </label>
                    <span class="text-xs
                            @if( profit_percentage($product->wholesale_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif">
                            {{ profit_percentage($product->wholesale_price,$product->cost) }}
                    </span>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">AVE COST: </span>
                    <p>
                        @php
                            $lastPurchasePrice = to_rands($product->last_cost) ?? 0
                        @endphp
                        @if($lastPurchasePrice > $product->cost)
                            <span class="text-green-600 font-extrabold w-4"> &downarrow; </span>
                        @elseif($lastPurchasePrice == $product->cost)
                            <span class="text-gray-600 font-extrabold w-4"> &rightarrow; </span>
                        @else
                            <span class="text-red-700 font-extrabold w-4"> &uparrow; </span>
                        @endif
                        {{ number_format($product->cost,2) ?? 0}}
                    </p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">LAST COST: </span>
                    <p>{{ number_format($lastPurchasePrice,2) ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">PURCHASED: </span>
                    <p>{{ $product->total_bought ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">RETURNS: </span>
                    <p>{{ $product->total_returned ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">SOLD: </span>
                    <p>{{ $product->total_sold ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold lg:hidden underline">AVAILABLE: </span>
                    <p>{{ $product->total_available ?? 0}}</p>
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
</div>
