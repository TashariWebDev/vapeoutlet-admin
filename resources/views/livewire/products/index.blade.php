<div wire:key>
    <x-slide-over title="Product gallery"
                  wire:model.defer="showGalleryForm"
    >
        @if($product)
            <div>
                <div class="grid grid-cols-4 gap-2 p-3">
                    @forelse($product->images as $image)
                        <div class="relative col-span-1 w-20 h-20 rounded-md">
                            <div class="absolute top-0 right-0">
                                <button wire:loading.attr="disabled"
                                        x-on:click="@this.call('deleteImage',{{$image->id}})"
                                >
                                    <x-icons.cross class="w-6 h-6 text-red-600"/>
                                </button>
                            </div>
                            <img src="{{asset($image->url)}}"
                                 alt=""
                                 class="object-cover rounded-md"
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
                @if($product)
                    <div class="relative col-span-1 w-32 h-32 rounded-md border">
                        @if(!str_contains($product->image,'default-image.png'))
                            <div class="absolute top-0 right-0">
                                <button x-on:click="@this.call('deleteFeaturedImage')">
                                    <x-icons.cross class="w-6 h-6 text-red-600"/>
                                </button>
                            </div>
                        @endif
                        <img src="{{ asset($product->image) }}"
                             alt=""
                             class="object-cover rounded-t-md"
                        >
                    </div>
                    <div class="pt-1 mx-auto w-32 text-xs text-center rounded-b bg-slate-200">
                        <p>featured</p>
                    </div>
                @endif
            </div>
            <form wire:submit.prevent="saveFeaturedImage"
                  x-data=""
                  id="saveFeaturedImageForm"
                  x-on:livewire-upload-finish="document.getElementById('saveFeaturedImageForm').reset()"
            >
                <div class="py-2">
                    <x-input label="featured image"
                             type="file"
                             wire:model.defer="image"
                    />
                </div>
                <div class="py-2">
                    <button class="w-full button-success">
                        <x-icons.upload class="mr-2 w-5 h-5 text-white"/>
                        upload
                    </button>
                </div>
            </form>
            <form wire:submit.prevent="saveGallery"
                  x-data=""
                  id="saveGalleryForm"
                  x-on:livewire-upload-finish="document.getElementById('saveGalleryForm').reset()"
            >
                <div class="py-2">
                    <x-input type="file"
                             label="upload images"
                             multiple
                             wire:model.defer="images"
                    />
                </div>
                <div class="py-2">
                    <button class="w-full button-success">
                        <x-icons.upload class="mr-2 w-5 h-5 text-white"/>
                        upload
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    {{--update product--}}
    <x-slide-over title="Update product"
                  wire:model.defer="showProductUpdateForm"
    >
        <form wire:submit.prevent="update">
            <div class="py-2">
                <x-input label="name"
                         type="text"
                         wire:model.defer="product.name"
                         required
                />
            </div>
            <div class="py-2">
                <x-input label="sku"
                         type="text"
                         wire:model.defer="product.sku"
                         required
                />
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="brand"
                          wire:model.defer="product.brand"
                          required
                >
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showCategoriesForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="categories"
                          wire:model.defer="product.category"
                          required
                >
                    @foreach($categories as $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="Collection name"
                          wire:model.defer="product.product_collection_id"
                >
                    @foreach($productCollections as $collection)
                        <option value="{{$collection->id}}">{{$collection->name}}</option>
                    @endforeach
                </x-select>
            </div>
            @if($product)
                @if($product->id)
                    <div class="py-2">
                        <x-textarea label="description"
                                    type="text"
                                    wire:model.defer="product.description"
                        />
                    </div>
                    <div class="py-2">
                        <x-input-number label="retail_price"
                                        type="number"
                                        wire:model.defer="product.retail_price"
                                        required
                        />
                    </div>
                    <div class="py-2">
                        <x-input-number label="wholesale_price"
                                        type="number"
                                        wire:model.defer="product.wholesale_price"
                                        required
                        />
                    </div>
                    <div class="relative py-2">
                        <div class="absolute right-0 z-10 pt-0.5">
                            <button x-on:click.prevent="@this.set('showFeaturesForm',true)">
                                <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                            </button>
                        </div>
                        <x-select label="features"
                                  x-on:change="$wire.call('addFeature',$event.target.value)"
                        >
                            @foreach($featureCategories as $category)
                                <option value="{{$category->id}}"
                                        wire:key="{{$category->id}}"
                                >{{$category->name}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="py-2 px-4 rounded-md bg-slate-100">
                        <p class="text-xs">update and click tab to save</p>
                        @foreach($product->features as $feature)
                            <div class="relative py-2"
                                 wire:key="{{$feature->id}}"
                            >
                                <div class="absolute right-0 z-10 pt-0.5">
                                    <button x-on:click.prevent="@this.call('deleteFeature',{{$feature->id}})">
                                        <x-icons.cross class="w-12 h-12 text-red-500 hover:text-red-600"/>
                                    </button>
                                </div>
                                <x-input-alpine
                                    type="text"
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
                <button class="w-full button-success">
                    <x-icons.save class="mr-2 w-5 h-5"/>
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    {{--create product--}}
    <x-slide-over title="New product"
                  wire:model.defer="showProductCreateForm"
    >
        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-input label="name"
                         type="text"
                         wire:model.defer="product.name"
                         required
                />
            </div>
            <div class="py-2">
                <x-input label="sku"
                         type="text"
                         wire:model.defer="product.sku"
                         required
                />
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showBrandsForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="brand"
                          wire:model.defer="product.brand"
                          required
                >
                    @foreach($brands as $brand)
                        <option value="{{$brand->name}}">{{$brand->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showCategoriesForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="categories"
                          wire:model.defer="product.category"
                          required
                >
                    @foreach($categories as $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="relative py-4">
                <div class="absolute right-0 z-10 pt-0.5">
                    <button x-on:click.prevent="@this.set('showProductCollectionForm',true)">
                        <x-icons.plus class="w-12 h-12 text-green-500 hover:text-green-600"/>
                    </button>
                </div>
                <x-select label="Collection name"
                          wire:model.defer="product.product_collection_id"
                >
                    @foreach($productCollections as $collection)
                        <option value="{{$collection->id}}">{{$collection->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-2">
                <button class="w-full button-success">
                    <x-icons.save class="mr-2 w-5 h-5"/>
                    save
                </button>
            </div>
        </form>

        <button class="w-full button-success"
                x-on:click="@this.call('saveAndEdit','')"
        >
            <x-icons.save class="mr-2 w-5 h-5"/>
            save and update
        </button>
    </x-slide-over>

    <x-modal wire:model.defer="showBrandsForm"
             title="Manage brands"
             wire:key
    >
        <div>
            <form wire:submit.prevent="addBrand"
                  x-data=""
                  id="brandForm"
            >
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="brandName"
                             label="name"
                    />
                </div>
                <div class="py-2">
                    <x-input type="file"
                             wire:model.defer="brandLogo"
                             label="logo"
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

    <x-modal wire:model.defer="showProductCollectionForm"
             title="Manage product collections"
             wire:key
    >
        <div>
            <form wire:submit.prevent="addProductCollection">
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="collectionName"
                             label="Name"
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

    <x-modal wire:model.defer="showCategoriesForm"
             title="Manage categories"
    >
        <div>
            <form wire:submit.prevent="addCategory">
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="categoryName"
                             label="name"
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

    <x-modal wire:model.defer="showFeaturesForm"
             title="Manage feature categories"
    >
        <div>
            <form wire:submit.prevent="addFeatureCategory">
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="featureCategoryName"
                             label="name"
                    />
                </div>
                <div class="py-2">
                    <button
                        class="button-success"
                    >
                        <x-icons.save class="mr-2 w-5 h-5"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <div>
        <header class="grid grid-cols-1 gap-2 px-2 md:grid-cols-1 md:px-0 lg:grid-cols-2">

            <div>
                <x-inputs.search id="search"
                                 wire:model="searchQuery"
                                 label="Search"
                />
            </div>

            <div class="grid grid-cols-1 gap-2 items-center md:grid-cols-2">
                @if($activeFilter == true)
                    <button class="w-full button-success"
                            x-on:click="@this.set('activeFilter',false)"
                    >
                        <x-icons.arrow-down class="mr-2 w-5 h-5"/>
                        show disabled products
                    </button>
                @else
                    <button class="w-full button-success"
                            x-on:click.prevent="@this.set('activeFilter',true)"
                    >
                        <x-icons.arrow-up class="mr-2 w-5 h-5"/>
                        show active products
                    </button>
                @endif
                <div>
                    <button class="w-full button-success"
                            x-on:click.prevent="@this.call('create','')"
                    >
                        <x-icons.plus class="mr-2 w-5 h-5"/>
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
                    <div class="py-2 px-4 mb-2 w-full bg-white rounded-md dark:bg-slate-900">
                        <div
                            class="grid grid-cols-1 gap-y-3 py-2 text-sm font-medium lg:grid-cols-2 lg:gap-y-0 lg:py-0"
                        >
                            {{--left--}}

                            <x-product-listing :product="$product"/>

                            {{--right--}}
                            <div class="grid grid-cols-2 gap-y-2 gap-x-4 py-1 md:grid-cols-4">
                                {{--active--}}
                                <div>
                                    @if(($product->retail_price * $product->wholesale_price) > 0)
                                        @if($product->is_active)
                                            <button
                                                class="flex justify-center items-center space-x-2 w-full button-secondary"
                                                x-on:click="@this.call('toggleActive',{{$product->id}})"
                                            >
                                                <x-icons.tick class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                                <p>active</p>
                                            </button>
                                        @else
                                            <button
                                                class="flex justify-center items-center space-x-2 w-full button-secondary"
                                                x-on:click="@this.call('toggleActive',{{$product->id}})"
                                            >
                                                <x-icons.cross class="w-4 h-4 text-red-500 dark:text-red-400"/>
                                                <p>active</p>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                {{-- featured--}}
                                <div>
                                    @if($product->is_featured)
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('toggleFeatured',{{$product->id}})"
                                        >
                                            <x-icons.tick class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                            <p>featured</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('toggleFeatured',{{$product->id}})"
                                        >
                                            <x-icons.cross class="w-4 h-4 text-red-500 dark:text-red-400"/>
                                            <p>featured</p>
                                        </button>
                                    @endif
                                </div>
                                <div>
                                    @if($product->is_sale)
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('toggleSale',{{$product->id}})"
                                        >
                                            <x-icons.tick class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                            <p>sale</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('toggleSale',{{$product->id}})"
                                        >
                                            <x-icons.cross class="w-4 h-4 text-red-500 dark:text-red-400"/>
                                            <p>sale</p>
                                        </button>
                                    @endif
                                </div>
                                <div>
                                    <button class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('edit',{{$product->id}})"
                                    >
                                        <x-icons.edit class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                        <p>edit</p>
                                    </button>
                                </div>
                                <div>
                                    <button class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('showGallery',{{$product->id}})"
                                    >
                                        <x-icons.upload class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                        <p>gallery</p>
                                    </button>
                                </div>
                                <div></div>
                                <div></div>
                                <div>
                                    @if($product->trashed())
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('recover',{{$product->id}})"
                                        >
                                            <x-icons.tick class="w-4 h-4 text-green-500 dark:text-green-300"/>
                                            <p>recover</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-center items-center space-x-2 w-full button-secondary"
                                            x-on:click="@this.call('delete',{{$product->id}})"
                                        >
                                            <x-icons.cross class="w-4 h-4 text-red-500 dark:text-red-400"/>
                                            <p>archive</p>
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
