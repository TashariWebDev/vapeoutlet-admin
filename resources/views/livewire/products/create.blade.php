<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('slide')"
    >
        New product
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New product</h3>
        </div>

        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-form.input.label for="name">
                    Name
                </x-form.input.label>
                <x-form.input.text
                    id="name"
                    type="text"
                    wire:model.defer="name"
                    required
                />
                @error('name')
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
                    wire:model.defer="sku"
                    required
                />
                @error('sku')
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
                            wire:model.defer="brand"
                            required
                        >
                            <option value="">Choose</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('brand')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
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
                        <x-form.input.label for="category">
                            Category
                        </x-form.input.label>
                        <x-form.input.select
                            id="category"
                            wire:model.defer="category"
                            required
                        >
                            <option value="">Choose</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('category')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div>
                        <livewire:categories.create wire:key="add-category" />
                    </div>
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
                        wire:model.defer="product_collection_id"
                    >
                        <option value="">Choose</option>
                        @foreach ($productCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </x-form.input.select>

                    @error('product_collection_id')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
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
                <x-form.input.label for="description">
                    Description
                </x-form.input.label>
                <x-form.input.textarea
                    id="description"
                    type="text"
                    wire:model="description"
                />
                @error('description')
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
                    wire:model="retail_price"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                    required
                />
                @error('retail_price')
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
                    wire:model="wholesale_price"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                    required
                />
                @error('wholesale_price')
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
                <div>
                    <livewire:feature-categories.create wire:key="add-feature-category" />
                </div>
            </div>
            <div class="py-3">
                <div>
                    <p class="text-xs text-teal-500 dark:text-teal-400">update and click tab to save</p>
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

                        <button x-on:click.prevent="$wire.call('deleteFeature', {{ $feature->id }})">
                            <x-icons.cross class="w-10 h-10 text-pink-500 hover:text-pink-600" />
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
