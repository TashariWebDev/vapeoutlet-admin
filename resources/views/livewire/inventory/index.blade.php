<div>

    <x-slide-over
        title="New purchase"
        wire:model.defer="showPurchaseCreateForm"
    >
        <form wire:submit.prevent="save">
            <div class="relative">
                <div class="flex items-end py-2">
                    <div class="flex-1">
                        <x-form.input.label
                            for
                            supplier
                        >
                            Select a supplier
                        </x-form.input.label>
                        <x-form.input.select
                            id="supplier"
                            wire:model.defer="selectedSupplier"
                        >
                            <option value="">Choose</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('selectedSupplier')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <button x-on:click.prevent="$wire.set('showSuppliersCreateForm',true)">
                        <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                    </button>
                </div>

            </div>
            <div class="py-2">
                <x-form.input.label for="date">
                    date
                </x-form.input.label>
                <x-form.input.text
                    id="date"
                    type="date"
                    wire:model.defer="date"
                />
                @error('date')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="invoice_no">
                    Invoice no
                </x-form.input.label>
                <x-form.input.text
                    id="invoice_no"
                    type="text"
                    wire:model.defer="invoice_no"
                />
                @error('invoice_no')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="relative py-2">
                <x-form.input.label for="currency">
                    currency
                </x-form.input.label>
                <x-form.input.select
                    id="currency"
                    wire:model.defer="currency"
                >
                    <option value="ZAR">ZAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="CNH">CNH</option>
                </x-form.input.select>
                @error('currency')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="exchange_rate">
                    exchange rate in ZAR ( optional )
                </x-form.input.label>
                <x-form.input.text
                    id="exchange_rate"
                    type="number"
                    wire:model.defer="exchange_rate"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('exchange_rate')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="amount">
                    Invoice amount in selected currency ( ex shipping )
                </x-form.input.label>
                <x-form.input.text
                    id="amount"
                    type="number"
                    wire:model.defer="amount"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('amount')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="shipping_rate">
                    Shipping rate as % ( optional )
                </x-form.input.label>
                <x-form.input.text
                    id="shipping_rate"
                    type="number"
                    wire:model.defer="shipping_rate"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('shipping_rate')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2 px-2 mt-2 rounded-md text-slate-600 bg-slate-100 dark:text-slate-400 dark:bg-slate-700">
                <label
                    class="flex items-center space-x-2 text-xs font-medium uppercase"
                    for="taxable"
                >
                    <input
                        class="text-green-500 rounded-full focus:ring-slate-200"
                        id="taxable"
                        type="checkbox"
                        wire:model.defer="taxable"
                    />
                    <span class="ml-3">Taxable</span>
                </label>
                @error('taxable')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2 mt-2">
                <button class="button-success">
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <x-modal
        title="Manage suppliers"
        wire:model.defer="showSuppliersCreateForm"
    >
        <div>
            <form wire:submit.prevent="addSupplier">
                <div class="py-2">
                    <x-input
                        type="text"
                        label="Name"
                        wire:model.defer="name"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Email"
                        wire:model.defer="email"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Phone"
                        wire:model.defer="phone"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Contact person"
                        wire:model.defer="person"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Address line one"
                        wire:model.defer="address_line_one"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Address line two"
                        wire:model.defer="address_line_two"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Suburb"
                        wire:model.defer="suburb"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="City"
                        wire:model.defer="city"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Country"
                        wire:model.defer="country"
                    />
                </div>

                <div class="py-2">
                    <x-input
                        type="text"
                        label="Postal code"
                        wire:model.defer="postal_code"
                    />
                </div>

                <div class="py-2">
                    <button class="button-success">
                        <x-icons.save class="mr-2 w-5 h-5" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <div class="pb-5">
        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-400">Inventory</h3>
    </div>

    <div
        class="grid grid-cols-1 gap-y-4 py-3 px-2 rounded-lg shadow lg:grid-cols-4 lg:gap-x-3 bg-slate-100 dark:bg-slate-900">
        <div>
            <x-form.input.label for="search">
                Search
            </x-form.input.label>
            <x-form.input.text
                id="search"
                type="text"
                wire:model="searchQuery"
                autofocus
                placeholder="Search by name, SKU, category or brand"
            />
        </div>
        <div></div>
        <div class="flex items-end w-full">
            <button
                class="w-full button-success"
                x-on:click="$wire.set('showPurchaseCreateForm',true)"
            >
                new purchase
            </button>
        </div>

        <div class="flex items-end">
            <a
                class="w-full button-success"
                href="{{ route('suppliers') }}"
            >
                suppliers
            </a>
        </div>
    </div>

    {{--    @json($products) --}}

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
            <x-table.body class="grid grid-cols-1 text-sm md:grid-cols-12">
                <x-table.row class="text-center lg:col-span-2 lg:text-left">
                    <x-product-listing-simple :product="$product" />
                </x-table.row>
                <x-table.row>
                    @if (auth()->user()->hasPermissionTo('edit pricing'))
                        <label>
                            <input
                                class="px-0.5 w-full rounded border"
                                type="number"
                                value="{{ $product->retail_price }}"
                                label="retail"
                                inputmode="numeric"
                                pattern="[0-9]"
                                @keydown.tab="@this.call('updateRetailPrice',{{ $product->id }},$event.target.value)"
                            />
                        </label>
                    @else
                        <p class="text-center">{{ $product->retail_price }}</p>
                    @endif

                    @if (auth()->user()->hasPermissionTo('view cost'))
                        <span
                            class="@if (profit_percentage($product->retail_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif text-xs"
                        >
                            {{ profit_percentage($product->retail_price, $product->cost) }}
                        </span>
                    @endif
                </x-table.row>
                <x-table.row>
                    @if (auth()->user()->hasPermissionTo('edit pricing'))
                        <label>
                            <input
                                class="px-0.5 w-full rounded border"
                                type="number"
                                value="{{ $product->wholesale_price }}"
                                label="wholesale"
                                inputmode="numeric"
                                pattern="[0-9]"
                                @keydown.tab="@this.call('updateWholesalePrice',{{ $product->id }},$event.target.value)"
                            />
                        </label>
                    @else
                        <p class="text-center">{{ $product->wholesale_price }}</p>
                    @endif
                    @if (auth()->user()->hasPermissionTo('view cost'))
                        <span
                            class="@if (profit_percentage($product->wholesale_price, $product->cost) < 0) text-red-700 @else text-green-500 @endif text-xs"
                        >
                            {{ profit_percentage($product->wholesale_price, $product->cost) }}
                        </span>
                    @endif
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">AVE COST: </span>
                    @if (auth()->user()->hasPermissionTo('view cost'))
                        <p>
                            @php
                                $lastPurchasePrice = to_rands($product->last_cost) ?? 0;
                            @endphp
                            @if ($lastPurchasePrice > $product->cost)
                                <span class="w-4 font-extrabold text-green-600"> &downarrow; </span>
                            @elseif($lastPurchasePrice == $product->cost)
                                <span class="w-4 font-extrabold text-slate-600"> &rightarrow; </span>
                            @else
                                <span class="w-4 font-extrabold text-red-700"> &uparrow; </span>
                            @endif
                            {{ number_format($product->cost, 2) ?? 0 }}
                        </p>
                    @else
                        <p>---</p>
                    @endif
                </x-table.row>
                <x-table.row class="text-center">

                    @if (auth()->user()->hasPermissionTo('view cost'))
                        <span class="text-xs font-semibold underline lg:hidden">LAST COST: </span>
                        <p>{{ number_format($lastPurchasePrice, 2) ?? 0 }}</p>
                    @else
                        <p>---</p>
                    @endif
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">PUR: </span>
                    <p>{{ $product->total_bought ?? 0 }}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">INV: </span>
                    <p>{{ $product->total_sold ?? 0 }}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">CR: </span>
                    <p>{{ $product->total_returned ?? 0 }}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">ADJ: </span>
                    <p>{{ $product->total_adjustments ?? 0 }}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">SC: </span>
                    <p>{{ $product->total_supplier_credits ?? 0 }}</p>
                </x-table.row>
                <x-table.row class="text-center">
                    <span class="text-xs font-semibold underline lg:hidden">STOCK: </span>
                    <p>{{ $product->total_available ?? 0 }}</p>
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
</div>
