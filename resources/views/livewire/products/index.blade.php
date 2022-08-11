<div wire:key>
    <x-slide-over title="Product gallery" wire:model.defer="showGalleryForm">
        @if($product)
            <div>
                <div class="p-3 grid grid-cols-4 gap-2">
                    @forelse($product->images as $image)
                        <div class="col-span-1 w-20 h-20 rounded-md relative">
                            <div class="absolute top-0 right-0">
                                <button wire:loading.attr="disabled"
                                        x-on:click="@this.call('deleteImage',{{$image->id}})">
                                    <x-icons.cross class="w-6 h-6 text-red-600"/>
                                </button>
                            </div>
                            <img src="{{asset($image->url)}}" alt="" class="object-cover rounded-md">
                        </div>
                    @empty
                        <div class="col-span-4 bg-gray-100 w-full h-32 flex justify-center items-center">
                            <p class="text-gray-900 font-semibold">no images in gallery. Please upload</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <div>
            <div class="pb-4 pl-3 w-32">
                @if($product)
                    <div class="col-span-1 w-32 h-32 rounded-md relative border">
                        @if(!str_contains($product->image,'default-image.png'))
                            <div class="absolute top-0 right-0">
                                <button x-on:click="@this.call('deleteFeaturedImage')">
                                    <x-icons.cross class="w-6 h-6 text-red-600"/>
                                </button>
                            </div>
                        @endif
                        <img src="{{ asset($product->image) }}" alt="" class="object-cover rounded-t-md">
                    </div>
                    <div class="bg-gray-200 w-32 mx-auto rounded-b text-xs text-center pt-1">
                        <p>featured</p>
                    </div>
                @endif
            </div>
            <form wire:submit.prevent="saveFeaturedImage" x-data="" id="saveFeaturedImageForm"
                  x-on:livewire-upload-finish="document.getElementById('saveFeaturedImageForm').reset()">
                <div class="py-2">
                    <x-input label="featured image" type="file" wire:model.defer="image"/>
                </div>
                <div class="py-2">
                    <button class="button-success w-full">
                        <x-icons.upload class="w-5 h-5 text-white mr-2"/>
                        upload
                    </button>
                </div>
            </form>
            <form wire:submit.prevent="saveGallery" x-data="" id="saveGalleryForm"
                  x-on:livewire-upload-finish="document.getElementById('saveGalleryForm').reset()">
                <div class="py-2">
                    <x-input type="file" label="upload images" multiple wire:model.defer="images"/>
                </div>
                <div class="py-2">
                    <button class="button-success w-full">
                        <x-icons.upload class="w-5 h-5 text-white mr-2"/>
                        upload
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    {{--update product--}}
    <x-slide-over title="Update product" wire:model.defer="showProductUpdateForm">
        <form wire:submit.prevent="update">
            <div class="py-2">
                <x-input label="name" type="text" wire:model.defer="product.name" required/>
            </div>
            <div class="py-2">
                <x-input label="sku" type="text" wire:model.defer="product.sku" required/>
            </div>
            <div class="py-4 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="brand" wire:model.defer="product.brand" required>
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-4 relative">
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
            <div class="py-4 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="Collection name" wire:model.defer="product.product_collection_id">
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
                        <x-select label="features"
                                  x-on:change="$wire.call('addFeature',$event.target.value)">
                            @foreach($featureCategories as $category)
                                <option value="{{$category->id}}"
                                        wire:key="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="py-2 px-4 bg-gray-100 rounded-md">
                        <p class="text-xs">update and click tab to save</p>
                        @foreach($product->features as $feature)
                            <div class="py-2 relative" wire:key="{{$feature->id}}">
                                <div class="absolute right-0 pt-0.5 z-10">
                                    <button x-on:click.prevent="@this.call('deleteFeature',{{$feature->id}})">
                                        <x-icons.cross class="text-red-500 hover:text-red-600 w-12 h-12"/>
                                    </button>
                                </div>
                                <x-input-alpine type="text"
                                                value="{{$feature->name}}"
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
            <div class="py-4 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="brand" wire:model.defer="product.brand" required>
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-4 relative">
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
            <div class="py-4 relative">
                <div class="absolute right-0 pt-0.5 z-10">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                    </button>
                </div>
                <x-select label="Collection name" wire:model.defer="product.product_collection_id">
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
            <form wire:submit.prevent="addBrand" x-data="" id="brandForm"
                  x-on:livewire-upload-finish="document.getElementById('brandForm').reset()">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="brandName" label="name"/>
                </div>
                <div class="py-2">
                    <x-input type="file" wire:model.defer="brandLogo" label="logo"/>
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

    <x-modal wire:model.defer="showProductCollectionForm" title="Manage product collections" wire:key>
        <div>
            <form wire:submit.prevent="addProductCollection">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="collectionName" label="Name"/>
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
                    <x-input type="text" wire:model.defer="categoryName" label="name"/>
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
                    <x-input type="text" wire:model.defer="featureCategoryName" label="name"/>
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

    <div>
        <header class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2 px-2 md:px-0">

            <div>
                <x-inputs.search id="search" wire:model="searchQuery" label="Search"/>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-2">
                @if($activeFilter == true)
                    <button class="button-success w-full"
                            x-on:click="@this.set('activeFilter',false)"
                    >
                        <x-icons.arrow-down class="w-5 h-5 mr-2"/>
                        show disabled products
                    </button>
                @else
                    <button class="button-success w-full"
                            x-on:click.prevent="@this.set('activeFilter',true)"
                    >
                        <x-icons.arrow-up class="w-5 h-5 mr-2"/>
                        show active products
                    </button>
                @endif
                <div>
                    <button class="button-success w-full"
                            x-on:click.prevent="@this.call('create','')"
                    >
                        <x-icons.plus class="w-5 h-5 mr-2"/>
                        add product
                    </button>
                </div>
            </div>
        </header>

        <div class="py-3">
            {{ $products->links() }}
        </div>

        <section class="mt-4">
            <div>
                @forelse($products as $product)
                    <div class="w-full rounded-md bg-white px-4 py-2 mb-2">
                        <div
                            class="text-sm font-medium grid grid-cols-1 lg:grid-cols-2 gap-y-3 py-2 lg:gap-y-0 lg:py-0">
                            {{--left--}}
                            <div class="flex items-center space-x-4">
                                <div class="">
                                    <p class="font-semibold text-gray-800">
                                        {{ $product->brand }} {{ $product->name }}
                                    </p>
                                    <div class="flex space-x-1 items-center">
                                        @foreach($product->features as $feature)
                                            <p class="text-xs text-gray-600 pr-1 @if(!$loop->last) border-r @endif"
                                            > {{ $feature->name }}</p>
                                        @endforeach
                                    </div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $product->category}}
                                    </p>
                                </div>
                            </div>

                            {{--right--}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2 py-1">
                                {{--active--}}
                                <div>
                                    @if(($product->retail_price * $product->wholesale_price) > 0)
                                        @if($product->is_active)
                                            <button
                                                class="flex items-center justify-center space-x-2 button-secondary w-full"
                                                x-on:click="@this.call('toggleActive',{{$product->id}})"
                                            >
                                                <x-icons.tick class="text-green-500 w-4 h-4"/>
                                                <p class="text-sm font-medium">active</p>
                                            </button>
                                        @else
                                            <button
                                                class="flex items-center justify-center space-x-2 button-secondary w-full"
                                                x-on:click="@this.call('toggleActive',{{$product->id}})"
                                            >
                                                <x-icons.cross class="text-red-500 w-4 h-4"/>
                                                <p class="text-sm font-medium">active</p>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                {{-- featured--}}
                                <div>
                                    @if($product->is_featured)
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('toggleFeatured',{{$product->id}})"
                                        >
                                            <x-icons.tick class="text-green-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">featured</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('toggleFeatured',{{$product->id}})"
                                        >
                                            <x-icons.cross class="text-red-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">featured</p>
                                        </button>
                                    @endif
                                </div>
                                <div>
                                    @if($product->is_sale)
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('toggleSale',{{$product->id}})"
                                        >
                                            <x-icons.tick class="text-green-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">sale</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('toggleSale',{{$product->id}})"
                                        >
                                            <x-icons.cross class="text-red-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">sale</p>
                                        </button>
                                    @endif
                                </div>
                                <div>
                                    <button class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('edit',{{$product->id}})"
                                    >
                                        <x-icons.edit class="text-green-500 w-4 h-4"/>
                                        <p class="text-sm font-medium">edit</p>
                                    </button>
                                </div>
                                <div>
                                    <button class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('showGallery',{{$product->id}})"
                                    >
                                        <x-icons.upload class="text-green-500 w-4 h-4"/>
                                        <p class="text-sm font-medium">gallery</p>
                                    </button>
                                </div>
                                <div></div>
                                <div></div>
                                <div>
                                    @if($product->trashed())
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('recover',{{$product->id}})"
                                        >
                                            <x-icons.tick class="text-green-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">recover</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex items-center justify-center space-x-2 button-secondary w-full"
                                            x-on:click="@this.call('delete',{{$product->id}})"
                                        >
                                            <x-icons.cross class="text-red-500 w-4 h-4"/>
                                            <p class="text-sm font-medium">archive</p>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-table.empty></x-table.empty>
                @endforelse
            </div>

        </section>
    </div>
</div>
