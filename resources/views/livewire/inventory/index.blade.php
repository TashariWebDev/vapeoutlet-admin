<div>

    <x-slide-over wire:model.defer="showPurchaseCreateForm"
                  title="New purchase"
    >
        <form wire:submit.prevent="save">
            <div class="relative">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showSuppliersCreateForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <div class="py-4">
                    <x-select wire:model.defer="selectedSupplier"
                              label="Select a supplier"
                    >
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </x-select>
                </div>

            </div>
            <div class="py-4">
                <x-input type="date"
                         wire:model.defer="date"
                         label="Invoice date"
                />
            </div>
            <div class="py-4">
                <x-input type="text"
                         wire:model.defer="invoice_no"
                         label="Invoice number"
                />
            </div>
            <div class="relative py-4">
                <x-select wire:model.defer="currency"
                          label="Select a currency"
                >
                    <option value="ZAR">ZAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="CNH">CNH</option>
                </x-select>
            </div>
            <div class="py-4">
                <x-input-number type="number"
                                wire:model.defer="exchange_rate"
                                placeholder="optional"
                                label="Exchange rate in ZAR"
                />
            </div>
            <div class="py-4">
                <x-input-number type="number"
                                wire:model.defer="amount"
                                label="Invoice amount in selected currency (ex shipping)"
                />
            </div>
            <div class="py-4">
                <x-input-number type="number"
                                wire:model.defer="shipping_rate"
                                label="Shipping rate as %"
                />
            </div>
            <div class="py-2 px-2 rounded-md bg-slate-100">
                <label for="taxable"
                       class="flex items-center space-x-2 text-xs font-medium uppercase"
                >
                    <input type="checkbox"
                           wire:model.defer="taxable"
                           id="taxable"
                           class="text-green-500 rounded-full focus:ring-slate-200"
                    />
                    <span class="ml-3">Taxable</span>
                </label>
            </div>
            <div class="py-4">
                <button class="button-success">
                    <x-icons.save class="mr-2 w-5 h-5"/>
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <x-modal title="Manage suppliers"
             wire:model.defer="showSuppliersCreateForm"
    >
        <div>
            <form wire:submit.prevent="addSupplier">
                <div class="py-2">
                    <x-input type="text"
                             label="Name"
                             wire:model.defer="name"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Email"
                             wire:model.defer="email"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Phone"
                             wire:model.defer="phone"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Contact person"
                             wire:model.defer="person"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Address line one"
                             wire:model.defer="address_line_one"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Address line two"
                             wire:model.defer="address_line_two"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Suburb"
                             wire:model.defer="suburb"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="City"
                             wire:model.defer="city"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Country"
                             wire:model.defer="country"
                    />
                </div>

                <div class="py-2">
                    <x-input type="text"
                             label="Postal code"
                             wire:model.defer="postal_code"
                    />
                </div>

                <div class="py-2">
                    <button class="button-success">
                        <x-icons.save class="mr-2 w-5 h-5"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>


    <div class="grid grid-cols-1 gap-2 px-2 md:px-0 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <x-inputs.search id="search"
                             wire:model="searchQuery"
                             label="Search"
            />
        </div>

        <div class="w-full">
            <button class="w-full button-success"
                    x-on:click="$wire.set('showPurchaseCreateForm',true)"
            >
                <x-icons.plus class="mr-2 w-5"/>
                new purchase
            </button>
        </div>

        <div>
            <a href="{{ route('suppliers') }}"
               class="w-full button-success"
            >
                <x-icons.users class="mr-2 w-5"/>
                suppliers
            </a>
        </div>
    </div>

    {{--    @json($products)--}}

    <div class="py-3">
        {{ $products->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden grid-cols-1 md:grid-cols-12 lg:grid">
            <x-table.heading class="col-span-2">product</x-table.heading>
            <x-table.heading class="text-center">retail</x-table.heading>
            <x-table.heading class="text-center">wholesale</x-table.heading>
            <x-table.heading class="text-center">ave cost</x-table.heading>
            <x-table.heading class="text-center">last cost</x-table.heading>
            <x-table.heading class="text-center">PUR</x-table.heading>
            <x-table.heading class="text-center">INV</x-table.heading>
            <x-table.heading class="text-center">CR</x-table.heading>
            <x-table.heading class="text-center">ADJ</x-table.heading>
            <x-table.heading class="text-center">SC</x-table.heading>
            <x-table.heading class="text-center">STOCK</x-table.heading>
        </x-table.header>
        @forelse($products as $product)
            <x-table.body
                class="grid grid-cols-1 text-sm md:grid-cols-12"
            >
                <x-table.row class="text-center lg:col-span-2 lg:text-left">
                    <x-product-listing-simple :product="$product"/>
                </x-table.row>
                <x-table.row>
                    @hasPermissionTo('edit pricing')
                    <label>
                        <input type="number"
                               value="{{ $product->retail_price }}"
                               label="retail"
                               inputmode="numeric"
                               pattern="[0-9]"
                               class="px-0.5 w-full rounded border"
                               @keydown.tab="@this.call('updateRetailPrice',{{$product->id}},$event.target.value)"
                        />
                    </label>
                    @else
                        <p class="text-center">{{ $product->retail_price }}</p>
                        @endhasPermissionTo

                        @hasPermissionTo('view cost')
                        <span class="text-xs
                            @if( profit_percentage($product->retail_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif"
                        >
                            {{ profit_percentage($product->retail_price,$product->cost) }}
                    </span>
                        @endhasPermissionTo
                </x-table.row>
                <x-table.row>
                    @hasPermissionTo('edit pricing')
                    <label>
                        <input type="number"
                               value="{{ $product->wholesale_price }}"
                               label="wholesale"
                               inputmode="numeric"
                               pattern="[0-9]"
                               class="px-0.5 w-full rounded border"
                               @keydown.tab="@this.call('updateWholesalePrice',{{$product->id}},$event.target.value)"
                        />
                    </label>
                    @else
                        <p class="text-center">{{ $product->wholesale_price }}</p>
                        @endhasPermissionTo
                        @hasPermissionTo('view cost')
                        <span class="text-xs
                            @if( profit_percentage($product->wholesale_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif"
                        >
                            {{ profit_percentage($product->wholesale_price,$product->cost) }}
                    </span>
                        @endhasPermissionTo
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">AVE COST: </span>
                    @hasPermissionTo('view cost')
                    <p>
                        @php
                            $lastPurchasePrice = to_rands($product->last_cost) ?? 0
                        @endphp
                        @if($lastPurchasePrice > $product->cost)
                            <span class="w-4 font-extrabold text-green-600"> &downarrow; </span>
                        @elseif($lastPurchasePrice == $product->cost)
                            <span class="w-4 font-extrabold text-slate-600"> &rightarrow; </span>
                        @else
                            <span class="w-4 font-extrabold text-red-700"> &uparrow; </span>
                        @endif
                        {{ number_format($product->cost,2) ?? 0}}
                    </p>
                    @else
                        <p>---</p>
                        @endhasPermissionTo
                </x-table.row>
                <x-table.row class="text-center">

                    @hasPermissionTo('view cost')
                    <span class="text-xs font-semibold underline lg:hidden">LAST COST: </span>
                    <p>{{ number_format($lastPurchasePrice,2) ?? 0}}</p>
                    @else
                        <p>---</p>
                        @endhasPermissionTo
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">PUR: </span>
                    <p>{{ $product->total_bought ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">INV: </span>
                    <p>{{ $product->total_sold ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">CR: </span>
                    <p>{{ $product->total_returned ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">ADJ: </span>
                    <p>{{ $product->total_adjustments ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">SC: </span>
                    <p>{{ $product->total_supplier_credits ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">STOCK: </span>
                    <p>{{ $product->total_available ?? 0}}</p>
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
</div>
