<div x-data="{}">
    <x-loading-screen/>

    <x-slide-over title="Update product" wire:model.defer="showProductUpdateForm">
        <form wire:submit.prevent="update">
            <div class="py-2">
                <x-input label="name" type="text" wire:model.defer="product.name" required/>
            </div>
            <div class="py-2">
                <x-input label="sku" type="text" wire:model.defer="product.sku" required/>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="brand" type="text" wire:model.defer="product.brand" required>
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showCategoriesForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="categories" wire:model.defer="product.category" required>
                    @foreach($categories as $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="Collection name" type="text" wire:model.defer="product.product_collection_id">
                    @foreach($productCollections as $collection)
                        <option value="{{$collection->id}}">{{$collection->name}}</option>
                    @endforeach
                </x-select>
            </div>
            @if($product)
                @if($product->id)
                    <div class="py-2">
                        <x-textarea label="description" type="text" wire:model.defer="product.description"/>
                    </div>
                    <div class="py-2">
                        <x-input-number label="retail_price" type="number" wire:model.defer="product.retail_price"
                                        required/>
                    </div>
                    <div class="py-2">
                        <x-input-number label="wholesale_price" type="number"
                                        wire:model.defer="product.wholesale_price"
                                        required/>
                    </div>
                    <div class="py-2 relative">
                        <div class="absolute right-0 pt-0.5 z-10">
                            <button x-on:click.prevent="@this.set('showFeaturesForm',true)">
                                <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                            </button>
                        </div>
                        <x-select label="features" type="text"
                                  wire:change="addFeature($event.target.value)">
                            @foreach($featureCategories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="py-2 px-4 bg-gray-100 rounded-md">
                        <p class="text-xs">update and click tab to save</p>
                        @foreach($product->features as $feature)
                            <div class="py-2 relative">
                                <div class="absolute right-0 pt-0.5 z-10">
                                    <button x-on:click.prevent="@this.call('deleteFeature',{{$feature->id}})">
                                        <x-icons.cross class="text-red-500 hover:text-red-600 w-12 h-12"/>
                                    </button>
                                </div>
                                <x-input-alpine type="text"
                                                value="{{$feature->name ?? ''}}"
                                                name="name"
                                                label="{{$feature->category->name}}"
                                                id="{{$feature->category->name}}-{{$feature->id}}"
                                                x-on:blur="$wire.call('updateFeature',{{$feature->id}},$event.target.value)"
                                />
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            <div class="py-2">
                <button class="button-success w-full">
                    <x-icons.save class="w-5 h-5 mr-2"/>
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    {{--create product--}}
    <x-slide-over title="New product" wire:model.defer="showProductCreateForm">
        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-input label="name" type="text" wire:model.defer="product.name" required/>
            </div>
            <div class="py-2">
                <x-input label="sku" type="text" wire:model.defer="product.sku" required/>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="brand" type="text" wire:model.defer="product.brand" required>
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showCategoriesForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="categories" type="text" wire:model.defer="product.category" required>
                    @foreach($categories as $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="Collection name" type="text" wire:model.defer="product.product_collection_id">
                    @foreach($productCollections as $collection)
                        <option value="{{$collection->id}}">{{$collection->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2">
                <button class="button-success w-full">
                    <x-icons.save class="w-5 h-5 mr-2"/>
                    save
                </button>
            </div>
        </form>

        <button class="button-success w-full"
                x-on:click="@this.call('saveAndEdit','')"
        >
            <x-icons.save class="w-5 h-5 mr-2"/>
            save and update
        </button>
    </x-slide-over>

    <x-modal wire:model.defer="showBrandsForm" title="Manage brands" wire:key>
        <div>
            <form wire:submit.prevent="addBrand" x-data="" id="brandForm">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="brandName" label="name" required/>
                </div>
                <div class="py-2">
                    <x-input type="file" wire:model.defer="brandLogo" label="logo" required/>
                </div>
                <div class="py-2">
                    <button class="button-success" x-on:click="document.getElementById('brandForm').reset()">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal wire:model.defer="showProductCollectionForm" title="Manage product collections" wire:key>
        <div>
            <form wire:submit.prevent="addProductCollection">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="collectionName" label="Name" required/>
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

    <x-modal wire:model.defer="showCategoriesForm" title="Manage categories">
        <div>
            <form wire:submit.prevent="addCategory">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="categoryName" label="name" required/>
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

    <x-modal wire:model.defer="showFeaturesForm" title="Manage feature categories">
        <div>
            <form wire:submit.prevent="addFeatureCategory">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="featureCategoryName" label="name" required/>
                </div>
                <div class="py-2">
                    <button
                        class="button-success"
                    >
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal title="Are you sure?" wire:model.defer="showConfirmModal">
        <div class="flex space-x-4 py-4">
            <button class="button-success"
                    x-on:click="$wire.call('process')"
            >
                <x-icons.tick class="w-5 h-5 mr-2"/>
                Yes! Process
            </button>
            <button class="button-secondary w-32"
                    x-on:click="$wire.set('showConfirmModal',false)"
            >
                <x-icons.cross class="w-5 h-5 mr-2"/>
                No
            </button>
        </div>
    </x-modal>

    <div>
        <div class="grid grid-col-1 md:grid-cols-4 gap-3 px-2 py-1 border-b pb-4 bg-white rounded-md">
            <div class="order-last md:order-first md:col-span-2">
                @if(!$this->purchase->processed)
                    <div class="pb-3 grid grid-cols-1 lg:grid-cols-2 gap-2">
                        @if($this->purchase->total != $this->purchase->amount)
                            <button class="button-success w-full"
                                    x-on:click="@this.set('showProductSelectorForm',true)"
                            >
                                <x-icons.plus class="w-5 h-5 mr-2"/>
                                add products
                            </button>
                        @endif
                        <button class="button-success"
                                x-on:click.prevent="@this.call('create','')"
                        >
                            <x-icons.plus class="w-5 h-5 mr-2"/>
                            create new product
                        </button>
                    </div>
                @else
                    <div class="pb-3">
                        <button class="button-danger w-full" disabled
                        >Processed by {{$this->purchase->creator->name}} on {{ $this->purchase->processed_date }}
                        </button>
                    </div>
                @endif
                <div class="bg-gray-200 rounded-md px-2">
                    <p>
                        <span
                            class="@if($this->purchase->total === $this->purchase->amount)text-green-600 @else text-red-600 @endif">
                            {{$this->purchase->total}} {{$this->purchase->currency}}
                        </span>
                        <span class="font-bold">/ {{$this->purchase->amount}} {{$this->purchase->currency}}</span>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl underline underline-offset-4 pl-4">
                    {{ money($this->purchase->amount_converted_to_zar()) }}
                </h1>
                <h2>
                    <span class="text-xs">shipping</span> {{ money($this->purchase->shipping_cost()) }}
                    <span class="text-xs">vat</span> {{ money(vat($this->purchase->total_cost_in_zar())) }}
                </h2>
                <h2>
                    <span class="text-xs">amount</span>
                    {{ $this->purchase->amount_converted_to_zar() }} ZAR |
                    {{$this->purchase->amount}} {{ $this->purchase->currency }}
                </h2>
                @if(!$this->purchase->processed)
                    <div>
                        <button class="button-danger w-full"
                                x-on:click="@this.call('cancel')">
                            <x-icons.cross class="w-5 h-5 mr-2"/>
                            cancel
                        </button>
                    </div>
                    @if(!$this->purchase->processed)
                        <div>
                            <button class="button-success w-full lg:hidden mt-2"
                                    x-on:click="@this.set('showConfirmModal',true)"
                            >
                                <x-icons.tick class="w-5 h-5 mr-2"/>
                                process
                            </button>
                        </div>
                    @endif
                @endif
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl">{{ $this->purchase->invoice_no }}</h1>
                <a class="text-right font-bold underline underline-offset-2 text-green-600 hover:text-yellow-500"
                   href="{{ route('suppliers/show',$this->purchase->supplier->id) }}">{{ $this->purchase->supplier->name }}</a>
                <h2>{{ $this->purchase->date->format('Y-M-d') }}</h2>
                @if(!$this->purchase->processed)
                    <div>
                        <button class="button-success w-full hidden lg:flex"
                                x-on:click="@this.set('showConfirmModal',true)"
                        >
                            <x-icons.tick class="w-5 h-5 mr-2"/>
                            process
                        </button>
                    </div>
                @endif
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
                                    <div class="rounded-full hidden lg:block">
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

        <x-table.container>
            <x-table.header class="hidden lg:grid grid-cols-1 lg:grid-cols-4">
                <x-table.heading class="text-center lg:text-left">Product</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Price</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Qty</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Subtotal</x-table.heading>
            </x-table.header>
            @foreach($this->purchase->items as $item)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        <p class="text-xs text-gray-400">{{ $item->product->sku }}</p>
                        <h4 class="font-bold">
                            {{ $item->product->brand }} {{ $item->product->name }}
                        </h4>
                        <div class="flex flex-wrap justify-center lg:justify-start items-center">
                            @foreach($item->product->features as $feature)
                                <p class="text-xs text-gray-600 border-r pr-1 @if(!$loop->first) pl-1 @endif"
                                > {{ $feature->name }}</p>
                            @endforeach
                        </div>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if(!$this->purchase->processed)
                            <div>
                                <x-input-number type="number" label="Price {{ $this->purchase->currency }}"
                                                value="{{$item->price}}"
                                                x-on:keydown.enter="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{number_format($item->price,2)}} {{ $this->purchase->currency }}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if(!$this->purchase->processed)
                            <div>
                                <x-input-number type="number" label="Qty"
                                                value="{{$item->qty}}"
                                                x-on:keydown.enter="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{$item->qty}}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        {{ number_format($item->line_total,2) }} {{$this->purchase->currency}}
                        @if(!$this->purchase->processed)
                            <button wire:loading.attr="disabled"
                                    x-on:click="@this.call('deleteItem','{{$item->id}}')"
                                    class="text-red-400 hover:text-red-700">
                                remove
                            </button>
                        @endif
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
