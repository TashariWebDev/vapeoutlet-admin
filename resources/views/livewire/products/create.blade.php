<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('slide')"
    >
        New product
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New product</h3>
        </div>

        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-input.label for="name">
                    Name
                </x-input.label>
                <x-input.text
                    id="name"
                    type="text"
                    wire:model.defer="name"
                    required
                />
                @error('name')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="sku">
                    SKU
                </x-input.label>
                <x-input.text
                    id="sku"
                    type="text"
                    wire:model.defer="sku"
                    required
                />
                @error('sku')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <div class="flex items-end">
                    <div class="flex-1">
                        <x-input.label for="brand">
                            Brand
                        </x-input.label>
                        <x-input.select
                            id="brand"
                            type="text"
                            wire:model.defer="brand"
                            required
                        >
                            <option value="">Choose</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </x-input.select>
                        @error('brand')
                            <x-input.error>{{ $message }}</x-input.error>
                        @enderror
                    </div>
                    <div>
                        <livewire:brands.create wire:key="add-brand" />
                    </div>
                </div>
            </div>
            <div class="py-2">
                <div class="flex items-end">
                    <div class="flex-1">
                        <x-input.label for="category">
                            Category
                        </x-input.label>
                        <x-input.select
                            id="category"
                            wire:model.defer="category"
                            required
                        >
                            <option value="">Choose</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </x-input.select>
                        @error('category')
                            <x-input.error>{{ $message }}</x-input.error>
                        @enderror
                    </div>
                    <div>
                        <livewire:categories.create wire:key="add-category" />
                    </div>
                </div>
            </div>
            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-input.label for="collection">
                        Collection ( optional )
                    </x-input.label>

                    <x-input.select
                        id="collection"
                        type="text"
                        wire:model.defer="product_collection_id"
                    >
                        <option value="">Choose</option>
                        @foreach ($productCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </x-input.select>

                    @error('product_collection_id')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div>
                    <livewire:collections.create wire:key="add-collection" />
                </div>
            </div>
            @if (!$product)
                <div class="py-2">
                    <button
                        class="w-full button-success"
                        wire:click="save"
                    >
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            @endif
        </form>

        @if ($product)
            <div class="py-2">
                <x-input.label for="description">
                    Description
                </x-input.label>
                <x-input.textarea
                    id="description"
                    type="text"
                    wire:model="description"
                />
                @error('description')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="retail_price">
                    Retail price
                </x-input.label>
                <x-input.text
                    id="retail_price"
                    type="number"
                    wire:model="retail_price"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                    required
                />
                @error('retail_price')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="wholesale_price">
                    wholesale price
                </x-input.label>
                <x-input.text
                    id="wholesale_price"
                    type="number"
                    wire:model="wholesale_price"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                    required
                />
                @error('wholesale_price')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="flex items-end py-2">
                <div class="flex-1">
                    <x-input.label for="features">
                        features
                    </x-input.label>
                    <x-input.select
                        id="features"
                        type="text"
                        wire:change="addFeature($event.target.value)"
                    >
                        <option value="">Choose</option>
                        @foreach ($featureCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div>
                    <livewire:feature-categories.create wire:key="add-feature-category" />
                </div>
            </div>
            <div class="py-3">
                <div>
                    <p class="text-xs text-sky-500 dark:text-sky-400">update and click tab to save</p>
                </div>

                @foreach ($product->features as $feature)
                    <div class="flex items-end py-2">

                        <div class="flex-1">
                            <x-input.label for="{{ $feature->category->name }}-{{ $feature->id }}">
                                {{ $feature->category->name }}
                            </x-input.label>
                            <x-input.text
                                id="{{ $feature->category->name }}-{{ $feature->id }}"
                                type="text"
                                value="{{ $feature->name ?? '' }}"
                                x-on:blur="$wire.call('updateFeature',{{ $feature->id }},$event.target.value)"
                            />
                        </div>

                        <button x-on:click.prevent="$wire.call('deleteFeature', {{ $feature->id }})">
                            <x-icons.cross class="w-10 h-10 text-rose-500 hover:text-rose-600" />
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="py-2">
                <button
                    class="w-full button-success"
                    wire:click="update"
                >
                    <x-icons.busy target="save" />
                    save
                </button>
            </div>
        @endif
    </x-slide-over>

</div>
