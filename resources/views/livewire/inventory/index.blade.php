<div x-data="{currency:'ZAR'}">

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
                <x-select wire:model.defer="currency" x-model="currency"
                          label="Select a currency">
                    <option value="ZAR">ZAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="CNH">CNH</option>
                </x-select>
            </div>
            <template x-if="currency !== 'ZAR'">
                <div class="py-4">
                    <x-input-number type="number" wire:model.defer="exchange_rate"
                                    label="Exchange rate in ZAR"/>
                </div>
            </template>
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


    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-2 md:px-0">
        <div class="lg:col-span-2">
            <x-input-search id="search" wire:model="searchQuery" label="Search"/>
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
            <a href="{{ route('purchases') }}" class="button-success w-full">
                <x-icons.tax-receipt class="w-5 w-5 mr-2"/>
                purchases
            </a>
        </div>
        <div>
            <a href="{{ route('suppliers') }}" class="button-success w-full">
                <x-icons.users class="w-5 w-5 mr-2"/>
                suppliers
            </a>
        </div>
    </div>


    <div class="py-6">
        @if($products->isNotEmpty())
            <div
                class="hidden lg:grid grid-cols-4 md:grid-cols-9 border text-sm bg-white rounded-t text-sm font-semibold uppercase py-2 bg-gradient-gray text-white">
                <div class="border-r px-2">sku</div>
                <div class="col-span-2 border-r px-2">product</div>
                <div class="border-r px-2 text-right">ave cost</div>
                <div class="border-r px-2 text-right">last cost</div>
                <div class="border-r px-2 text-right">purchased</div>
                <div class="border-r px-2 text-right">returns</div>
                <div class="border-r px-2 text-right">sold</div>
                <div class="px-2 text-right">available</div>
            </div>
        @endif


        <div class="grid grid-cols-1 gap-2 py-2">
            @forelse($products as $product)
                <div class="grid grid-cols-4 lg:grid-cols-9 border text-sm bg-white lg:py-1
                            @if($loop->last) rounded-b @endif">
                    <div class="border-r lg:py-0">
                        <div class="lg:hidden bg-gradient-gray text-white px-2">
                            <p>id</p>
                        </div>
                        <p class="text-xs px-2">{{ $product->sku }}</p>
                    </div>
                    <div class="col-span-3 lg:col-span-2 border-r lg:px-2 lg:py-0">
                        <div class="lg:hidden bg-gradient-gray text-white px-2">
                            <p>name</p>
                        </div>
                        <div class="lg:block lg:flex items-center px-2 lg:px-0">
                            <p class="pr-3">
                                <span class="text-lg font-bold">{{ $product->brand }} {{ $product->name }}</span>
                                @if($product->trashed())
                                    <span class="text-xs text-red-600"> (discontinued) </span>
                                @endif
                            </p>
                            <div class="flex flex-wrap space-x-1 lg:hidden">
                                @foreach($product->features as $feature)
                                    <p class="text-xs text-gray-500 uppercase">
                                        {{ $feature->name }}
                                        @if(!$loop->last) <span> / </span> @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="hidden lg:flex flex-wrap ">
                            @foreach($product->features as $feature)
                                <p class="text-xs text-gray-500 uppercase px-1">
                                    | {{ $feature->name }}
                                    {{--                                    @if(!$loop->last) <span> | </span> @endif--}}
                                </p>
                            @endforeach
                        </div>
                    </div>
                    <div class="border-r lg:px-2 lg:text-right text-center col-span-2 lg:col-span-1">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>ave. cost</p>
                        </div>
                        <p>{{ number_format($product->cost,2) ?? 0}}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:text-right text-center col-span-2 lg:col-span-1">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>last cost</p>
                        </div>
                        <p>{{ number_format($product->last_purchase_price(),2) ?? 0}}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:text-right text-center">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>purchased</p>
                        </div>
                        <p>{{ $product->purchased->sum('qty')}}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:text-right text-center">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>sold</p>
                        </div>
                        <p>{{ $product->sold->sum('qty')}}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:text-right text-center">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>returns</p>
                        </div>
                        <p>{{ $product->returns->sum('qty')}}</p>
                    </div>
                    <div class="lg:px-2 lg:text-right text-center">
                        <div class="lg:hidden bg-gradient-gray text-white">
                            <p>available</p>
                        </div>
                        <p>{{ $product->stocks->sum('qty')}}</p>
                    </div>
                </div>
            @empty
                <div class="py-6 grid grid-cols-1">
                    <div class="text-center py-10 bg-white rounded-md">
                        <x-icons.products class="mx-auto h-12 w-12 text-gray-400"/>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                        <div class="mt-6">
                            <a href="{{ route('products') }}" type="button"
                               class="button-success">
                                <x-icons.plus
                                    class="-ml-1 mr-2 h-5 w-5 animate-pulse rounded-full ring ring-white ring-1"/>
                                New Product
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="py-6">
        {{ $products->links() }}
    </div>
</div>
