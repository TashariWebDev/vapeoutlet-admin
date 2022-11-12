<div x-data="{}">
    <x-slide-over
        title="Update product"
        wire:model.defer="showProductUpdateForm"
    >
        <form wire:submit.prevent="update">
            <div class="py-2">
                <x-form.input.label for="name">
                    Name
                </x-form.input.label>
                <x-form.input.text
                    id="name"
                    type="text"
                    wire:model.defer="product.name"
                    required
                />
                @error('product.name')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="sku">
                    SKU
                </x-form.input.label>
                <x-form.input.text
                    id="sku"
                    type="text"
                    wire:model.defer="product.sku"
                    required
                />
                @error('product.sku')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <div class="flex items-end">
                    <div class="flex-1">
                        <x-form.input.label for="brand">
                            Brand
                        </x-form.input.label>
                        <x-form.input.select
                            id="brand"
                            type="text"
                            wire:model.defer="product.brand"
                            required
                        >
                            <option value="">Choose</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('product.brand')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <button x-on:click.prevent="$wire.set('showBrandsForm',true)">
                        <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                    </button>
                </div>
            </div>
            <div class="py-2">
                <div class="flex items-end">
                    <div class="flex-1">
                        <x-form.input.label for="category">
                            Category
                        </x-form.input.label>
                        <x-form.input.select
                            id="category"
                            wire:model.defer="product.category"
                            required
                        >
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('product.category')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <button x-on:click.prevent="$wire.set('showCategoriesForm',true)">
                        <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                    </button>
                </div>
            </div>
            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-form.input.label for="collection">
                        Collection ( optional )
                    </x-form.input.label>
                    <x-form.input.select
                        id="collection"
                        type="text"
                        wire:model.defer="product.product_collection_id"
                    >
                        <option value="">Choose</option>
                        @foreach ($productCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </x-form.input.select>
                    @error('product.product_collection_id')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <button x-on:click.prevent="$wire.set('showProductCollectionForm',true)">
                    <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                </button>
            </div>
            @if ($product)
                @if ($product->id)
                    <div class="py-2">
                        <x-form.input.label for="description">
                            Description
                        </x-form.input.label>
                        <x-form.input.textarea
                            id="description"
                            type="text"
                            wire:model.defer="product.description"
                        />
                        @error('product.description')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div class="py-2">
                        <x-form.input.label for="retail_price">
                            Retail price
                        </x-form.input.label>
                        <x-form.input.text
                            id="retail_price"
                            type="number"
                            wire:model.defer="product.retail_price"
                            autocomplete="off"
                            wire:keydown.enter.prevent
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                            required
                        />
                        @error('product.retail_price')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div class="py-2">
                        <x-form.input.label for="wholesale_price">
                            wholesale price
                        </x-form.input.label>
                        <x-form.input.text
                            id="wholesale_price"
                            type="number"
                            wire:model.defer="product.wholesale_price"
                            autocomplete="off"
                            wire:keydown.enter.prevent
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                            required
                        />
                        @error('product.wholesale_price')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div class="flex items-end py-2">
                        <div class="flex-1">
                            <x-form.input.label for="features">
                                features
                            </x-form.input.label>
                            <x-form.input.select
                                id="features"
                                type="text"
                                wire:change="addFeature($event.target.value)"
                            >
                                <option value="">Choose</option>
                                @foreach ($featureCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-form.input.select>
                        </div>
                        <button x-on:click.prevent="$wire.set('showFeaturesForm',true)">
                            <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                        </button>
                    </div>

                    <div class="py-3">
                        <div>
                            <p class="text-xs text-slate-600 dark:text-slate-400">update and click tab to save</p>
                        </div>

                        @foreach ($product->features as $feature)
                            <div class="flex items-end py-2">

                                <div class="flex-1">
                                    <x-form.input.label for="{{ $feature->category->name }}-{{ $feature->id }}">
                                        {{ $feature->category->name }}
                                    </x-form.input.label>
                                    <x-form.input.text
                                        id="{{ $feature->category->name }}-{{ $feature->id }}"
                                        type="text"
                                        value="{{ $feature->name ?? '' }}"
                                        x-on:blur="$wire.call('updateFeature',{{ $feature->id }},$event.target.value)"
                                    />
                                </div>

                                <button x-on:click.prevent="$wire.call('deleteFeature',{{ $feature->id }})">
                                    <x-icons.cross class="w-10 h-10 text-red-500 hover:text-red-600" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            <div class="py-2">
                <button class="w-full button-success">
                    <x-icons.busy target="update" />
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    {{-- create product --}}
    <x-slide-over
        title="New product"
        wire:model.defer="showProductCreateForm"
    >
        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-form.input.label for="name">
                    name
                </x-form.input.label>
                <x-form.input.text
                    id="name"
                    type="text"
                    wire:model.defer="product.name"
                    required
                />
                @error('product.name')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="sku">
                    sku
                </x-form.input.label>
                <x-form.input.text
                    id="sku"
                    type="text"
                    wire:model.defer="product.sku"
                    required
                />
                @error('product.sku')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-form.input.label for="brand">
                        brand
                    </x-form.input.label>
                    <x-form.input.select
                        id="brand"
                        type="text"
                        wire:model.defer="product.brand"
                        required
                    >
                        <option value="">Choose</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                        @endforeach
                    </x-form.input.select>
                    @error('product.brand')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <button
                    {{--                    wire:click.prevent="$emit('showDaBrandsForm')" --}}
                    x-on:click.prevent="$wire.set('showBrandsForm',true)"
                >
                    <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                </button>
            </div>
            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-form.input.label for="category">
                        category
                    </x-form.input.label>
                    <x-form.input.select
                        id="category"
                        type="text"
                        wire:model.defer="product.category"
                        required
                    >
                        <option value="">Choose</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form.input.select>
                    @error('product.category')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <button x-on:click.prevent="$wire.set('showCategoriesForm',true)">
                    <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                </button>
            </div>
            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-form.input.label for="collection">
                        collection ( optional )
                    </x-form.input.label>
                    <x-form.input.select
                        id="collection"
                        type="text"
                        wire:model.defer="product.product_collection_id"
                    >
                        <option value="">Choose</option>
                        @foreach ($productCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </x-form.input.select>
                    @error('product.product_collection_id')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <button x-on:click.prevent="$wire.set('showProductCollectionForm',true)">
                    <x-icons.plus class="w-10 h-10 text-green-500 hover:text-green-600" />
                </button>
            </div>
            <div class="py-2">
                <button class="w-full button-success">
                    <x-icons.busy target="save" />
                    save
                </button>
            </div>
        </form>

        <button
            class="w-full button-success"
            x-on:click="$wire.call('saveAndEdit','')"
        >
            <x-icons.busy target="saveAndEdit" />
            save and update
        </button>
    </x-slide-over>

    <x-modal
        title="Manage brands"
        wire:model.defer="showBrandsForm"
        wire:key
    >
        <div>
            <form
                id="brandForm"
                wire:submit.prevent="addBrand"
                x-data=""
            >
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="brandName"
                        label="name"
                        required
                    />
                </div>
                <div class="py-2">
                    <x-input
                        type="file"
                        wire:model.defer="brandLogo"
                        label="logo"
                        required
                    />
                </div>
                <div class="py-2">
                    <button
                        class="button-success"
                        x-on:click="document.getElementById('brandForm').reset()"
                    >
                        <x-icons.save class="mr-2 w-5 h-5" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal
        title="Manage product collections"
        wire:model.defer="showProductCollectionForm"
        wire:key
    >
        <div>
            <form wire:submit.prevent="addProductCollection">
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="collectionName"
                        label="Name"
                        required
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

    <x-modal
        title="Manage categories"
        wire:model.defer="showCategoriesForm"
    >
        <div>
            <form wire:submit.prevent="addCategory">
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="categoryName"
                        label="name"
                        required
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

    <x-modal
        title="Manage feature categories"
        wire:model.defer="showFeaturesForm"
    >
        <div>
            <form wire:submit.prevent="addFeatureCategory">
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="featureCategoryName"
                        label="name"
                        required
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

    <x-modal
        title="Are you sure?"
        wire:model.defer="showConfirmModal"
    >
        <div class="flex py-4 space-x-4">
            <button
                class="button-success"
                wire:loading.attr="disabled"
                wire:target="process"
                wire:click="process"
            >
                <x-icons.busy target="process" />
                Yes! Process
            </button>
            <button
                class="w-32 button-secondary"
                wire:loading.attr="disabled"
                wire:target="process"
                x-on:click="$wire.set('showConfirmModal',false)"
            >
                <x-icons.cross class="mr-2 w-5 h-5" />
                No
            </button>
        </div>
    </x-modal>

    <div>
        <div
            class="grid gap-3 py-1 px-2 pb-4 bg-white rounded-md border-b md:grid-cols-4 grid-col-1 dark:bg-slate-900">
            <div class="order-last md:order-first md:col-span-2">
                @if (!$this->purchase->processed)
                    <div class="grid grid-cols-1 gap-2 pb-3 lg:grid-cols-2">
                        {{--                        @if ($this->purchase->total != $this->purchase->amount) --}}
                        <button
                            class="w-full button-success"
                            x-on:click="$wire.set('showProductSelectorForm',true)"
                        >
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            add products
                        </button>
                        {{--                        @endif --}}
                        <button
                            class="button-success"
                            x-on:click.prevent="$wire.call('create','')"
                        >
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            create new product
                        </button>
                    </div>
                @else
                    <div class="pb-3">
                        <button
                            class="w-full button-danger"
                            disabled
                        >Processed by {{ $this->purchase->creator->name }} on {{ $this->purchase->processed_date }}
                        </button>
                    </div>
                @endif
                <div class="px-2 rounded-md bg-slate-200">
                    <p>
                        <span class="@if ($this->purchase->total === $this->purchase->amount) text-green-600 @else text-red-600 @endif">
                            {{ $this->purchase->total }} {{ $this->purchase->currency }}
                        </span>
                        <span class="font-bold">/ {{ $this->purchase->amount }}
                            {{ $this->purchase->currency }}</span>
                    </p>
                </div>
            </div>
            <div class="text-right text-slate-600 dark:text-slate-400">
                <h1 class="pl-4 text-4xl font-bold underline underline-offset-4">
                    {{ money($this->purchase->amount_converted_to_zar()) }}
                </h1>
                <h2>
                    <span class="text-xs">shipping</span> {{ money($this->purchase->shipping_cost()) }}
                    @if ($this->purchase->taxable)
                        <span class="text-xs">vat</span> {{ money(vat($this->purchase->total_cost_in_zar())) }}
                    @endif
                </h2>
                <h2>
                    <span class="text-xs">amount</span>
                    {{ $this->purchase->amount_converted_to_zar() }} ZAR |
                    {{ $this->purchase->amount }} {{ $this->purchase->currency }}
                </h2>
                @if (!$this->purchase->processed)
                    <div>
                        <button
                            class="w-full button-danger"
                            x-on:click="$wire.call('cancel')"
                        >
                            <x-icons.cross class="mr-2 w-5 h-5" />
                            cancel
                        </button>
                    </div>
                    @if (!$this->purchase->processed)
                        <div>
                            <button
                                class="mt-2 w-full lg:hidden button-success"
                                x-on:click="$wire.set('showConfirmModal',true)"
                            >
                                <x-icons.tick class="mr-2 w-5 h-5" />
                                process
                            </button>
                        </div>
                    @endif
                @endif
            </div>
            <div class="text-right">
                <h1 class="text-4xl font-bold text-slate-600 dark:text-slate-400">{{ $this->purchase->invoice_no }}
                </h1>
                <a
                    class="link"
                    href="{{ route('suppliers/show', $this->purchase->supplier->id) }}"
                >{{ $this->purchase->supplier->name }}</a>
                <h2 class="text-slate-600 dark:text-slate-400">{{ $this->purchase->date->format('Y-M-d') }}</h2>
                @if (!$this->purchase->processed)
                    <div>
                        <button
                            class="hidden w-full lg:flex button-success"
                            x-on:click="$wire.set('showConfirmModal',true)"
                        >
                            <x-icons.tick class="mr-2 w-5 h-5" />
                            process
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <x-slide-over
            title="Select products"
            x-cloak
            wire:model.defer="showProductSelectorForm"
        >
            <div x-data="{ searchQuery: @entangle('searchQuery') }">
                <div class="relative">
                    <x-form.input.label for="searchQuery">
                        Product search
                    </x-form.input.label>
                    <x-form.input.text
                        type="search"
                        x-model.lazy="searchQuery"
                        placeholder="search"
                    />
                </div>
                @if (count($products))
                    <div class="p-1">
                        <p class="text-xs font-semibold uppercase text-slate-500"> {{ count($products) }} results</p>
                    </div>
                @endif
            </div>

            <div class="pt-4">
                <form wire:submit.prevent="addProducts">
                    <div class="pb-6">
                        <button class="w-full button-success">
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            add
                        </button>
                    </div>
                    <fieldset class="space-y-2">
                        @forelse($products as $product)
                            <label
                                class="flex relative items-start py-2 px-4 rounded-md bg-slate-300 dark:bg-slate-800"
                            >
                                <div>
                                    <input
                                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500 border-slate-300"
                                        id="{{ $product->id }}"
                                        type="checkbox"
                                        value="{{ $product->id }}"
                                        aria-describedby="product"
                                        wire:model.defer="selectedProducts"
                                        wire:key="{{ $product->id }}"
                                    >
                                </div>
                                <div class="flex items-center ml-3 w-full lg:justify-between">
                                    <x-product-listing-simple :product="$product" />
                                    <div class="hidden rounded-full lg:block">
                                        <img
                                            class="w-10 h-10 rounded-full"
                                            src="{{ asset($product->image) }}"
                                            alt=""
                                        >
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
            <div class="py-3">
                {{--                {{ $products->links() }} --}}
            </div>
        </x-slide-over>

        <x-table.container>
            <x-table.header class="hidden grid-cols-1 lg:grid lg:grid-cols-4">
                <x-table.heading class="text-center lg:text-left">Product</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Price</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Qty</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Subtotal</x-table.heading>
            </x-table.header>
            @foreach ($this->purchase->items as $item)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        <p class="text-xs text-slate-400">{{ $item->product->sku }}</p>
                        <h4 class="font-bold">
                            {{ $item->product->brand }} {{ $item->product->name }}
                        </h4>
                        <div class="flex flex-wrap justify-center items-center lg:justify-start">
                            @foreach ($item->product->features as $feature)
                                <p class="pr-1 text-xs text-slate-600"> {{ $feature->name }}</p>
                            @endforeach
                        </div>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if (!$this->purchase->processed)
                            <div>
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-600"
                                        type="number"
                                        value="{{ $item->price }}"
                                        x-on:keydown.enter="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                        x-on:blur="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                    />
                                </label>
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{ number_format($item->price, 2) }} {{ $this->purchase->currency }}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if (!$this->purchase->processed)
                            <div>
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-600"
                                        type="number"
                                        value="{{ $item->qty }}"
                                        x-on:keydown.enter="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                        x-on:blur="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                    />
                                </label>
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{ $item->qty }}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        {{ number_format($item->line_total, 2) }} {{ $this->purchase->currency }}
                        @if (!$this->purchase->processed)
                            <button
                                class="text-red-400 hover:text-red-700"
                                wire:loading.attr="disabled"
                                x-on:click="$wire.call('deleteItem','{{ $item->id }}')"
                            >
                                remove
                            </button>
                        @endif
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
