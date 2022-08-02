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

    <div class="py-3">
        {{ $products->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid grid-cols-1 md:grid-cols-8">
            <x-table.heading class="col-span-2">product</x-table.heading>
            <x-table.heading class="text-center lg:text-right">ave cost</x-table.heading>
            <x-table.heading class="text-center lg:text-right">last cost</x-table.heading>
            <x-table.heading class="text-center lg:text-right">purchased</x-table.heading>
            <x-table.heading class="text-center lg:text-right">returns</x-table.heading>
            <x-table.heading class="text-center lg:text-right">sold</x-table.heading>
            <x-table.heading class="text-center lg:text-right">available</x-table.heading>
        </x-table.header>
        @forelse($products as $product)
            <x-table.body class="grid grid-cols-1 md:grid-cols-8 text-sm">
                <x-table.row class="lg:col-span-2 text-center lg:text-left">
                    <p class="text-xs">{{ $product->sku }}</p>
                    <p>
                        <span class="text-sm font-bold">{{ $product->brand }} {{ $product->name }}</span>
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
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">COST: </span>
                    <p>{{ number_format($product->cost,2) ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">AVE COST: </span>
                    <p>{{ number_format($product->last_purchase_price(),2) ?? 0}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">PURCHASED: </span>
                    <p>{{ $product->purchased->sum('qty')}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">RETURNS: </span>
                    <p>{{ $product->returns->sum('qty')}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">SOLD: </span>
                    <p>{{ $product->sold->sum('qty')}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    <span class="text-xs font-semibold lg:hidden underline">AVAILABLE: </span>
                    <p>{{ $product->stocks->sum('qty')}}</p>
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>
</div>
