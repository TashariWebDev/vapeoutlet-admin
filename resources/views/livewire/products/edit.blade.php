<div>
    <x-page-header class="pb-3">
        Edit {{ $product->fullName() }}
    </x-page-header>

    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
        <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input.label for="name">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="product.name"
                        required
                    />
                    @error('product.name')
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
                        wire:model.defer="product.sku"
                        required
                    />
                    @error('product.sku')
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
                                wire:model.defer="product.brand"
                                required
                            >
                                <option value="">Choose</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                                @endforeach
                            </x-input.select>
                            @error('product.brand')
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
                                wire:model.defer="product.category"
                                required
                            >
                                <option value="">Choose</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </x-input.select>
                            @error('product.category')
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
                            wire:model.defer="product.product_collection_id"
                        >
                            <option value="">Choose</option>
                            @foreach ($productCollections as $collection)
                                <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                            @endforeach
                        </x-input.select>

                        @error('product.product_collection_id')
                        <x-input.error>{{ $message }}</x-input.error>
                        @enderror
                    </div>
                    <div>
                        <livewire:collections.create wire:key="add-collection" />
                    </div>
                </div>

                <div class="py-2">
                    <x-input.label for="description">
                        Description
                    </x-input.label>
                    <x-input.textarea
                        id="description"
                        type="text"
                        wire:model="product.description"
                    />
                    @error('product.description')
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
                        wire:model="product.retail_price"
                        autocomplete="off"
                        wire:keydown.enter.prevent
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                        required
                    />
                    @error('product.retail_price')
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
                        wire:model="product.wholesale_price"
                        autocomplete="off"
                        wire:keydown.enter.prevent
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                        required
                    />
                    @error('product.wholesale_price')
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
                        update
                    </button>
                </div>
            </form>
        </div>

        <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
            @if ($product)
                <div>
                    <div class="grid grid-cols-3 gap-2 p-3 lg:grid-cols-6">
                        @forelse($product->images as $image)
                            <div
                                class="flex relative col-span-1 justify-center items-center w-20 h-20 bg-white rounded-md"
                            >
                                <div class="absolute top-0 right-0">
                                    <button
                                        wire:loading.attr="disabled"
                                        x-on:click="$wire.call('deleteImage','{{ $image->id }}')"
                                    >
                                        <x-icons.cross class="w-6 h-6 text-rose-600" />
                                    </button>
                                </div>
                                <img
                                    class="object-cover items-center h-full rounded-md"
                                    src="{{ asset($image->url) }}"
                                    alt=""
                                >
                            </div>
                        @empty
                            <div class="flex col-span-4 justify-center items-center w-full h-32 bg-slate-100">
                                <p class="font-semibold text-slate-900">no images in gallery. Please upload</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <div>
                <div class="pb-4 pl-3 w-32">
                    @if ($product)
                        <div
                            class="flex relative col-span-1 justify-center w-32 h-32 bg-white rounded-t-md border"
                        >
                            @if (!str_contains($product->image, 'no_image.jpeg'))
                                <div class="absolute top-0 right-0">
                                    <button x-on:click="$wire.call('deleteFeaturedImage')">
                                        <x-icons.cross class="w-6 h-6 text-rose-600" />
                                    </button>
                                </div>
                            @endif
                            <img
                                class="object-cover items-center h-full rounded-t-md"
                                src="{{ asset($product->image) }}"
                                alt=""
                            >
                        </div>
                        <div class="pt-1 mx-auto w-32 text-xs text-center rounded-b bg-slate-200">
                            <p>featured</p>
                        </div>
                    @endif
                </div>
                <div>
                    <form
                        id="saveFeaturedImageForm"
                        wire:submit.prevent="saveFeaturedImage"
                        x-data=""
                        x-on:livewire-upload-finish="document.getElementById('saveFeaturedImageForm').reset()"
                    >
                        <div class="py-2">
                            <x-input.label for="image">
                                Featured image
                            </x-input.label>
                            <x-input.text
                                id="image"
                                type="file"
                                wire:model.defer="image"
                            />
                            @error('image')
                            <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="py-2">
                            <button class="w-full button-success">
                                <x-icons.upload class="mr-2 w-5 h-5 text-white" />
                                upload
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <form
                        id="saveGalleryForm"
                        wire:submit.prevent="saveGallery"
                        x-data=""
                        x-on:livewire-upload-finish="document.getElementById('saveGalleryForm').reset()"
                    >
                        <div class="py-2">
                            <x-input.label for="images">
                                Gallery images
                            </x-input.label>
                            <x-input.text
                                type="file"
                                label="upload images"
                                multiple
                                wire:model.defer="images"
                            />
                        </div>
                        <div class="py-2">
                            <button class="w-full button-success">
                                <x-icons.upload class="mr-2 w-5 h-5 text-white" />
                                upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
