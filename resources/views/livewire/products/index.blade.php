<div>
    <div class="py-3 bg-white rounded-lg shadow dark:bg-slate-800">

        <header class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-2 lg:gap-x-3">

            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <div>
                    <x-form.input.label for="search">
                        Search
                    </x-form.input.label>
                    <x-form.input.text
                        class="w-full"
                        id="search"
                        type="search"
                        wire:model="searchQuery"
                        autofocus
                        autocomplete="off"
                        placeholder="Search by SKU, name, category or brand"
                    />
                </div>

                <div>
                    <x-form.input.label>
                        No of records
                    </x-form.input.label>
                    <x-form.input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-form.input.select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-2 items-center md:grid-cols-2">
                <div class="grid grid-cols-1 gap-2">
                    @if (auth()->user()->hasPermissionTo('edit products'))
                        <livewire:products.create wire:key="add={{ now() }}" />
                    @else
                        <button
                            class="button-success"
                            disabled
                        >Add product
                        </button>
                    @endif
                    <button
                        class="w-full button-success"
                        wire:click="toggleFilter"
                    >
                        show disabled products
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <a
                        class="w-full button-success"
                        href="{{ route('suppliers') }}"
                    >
                        suppliers
                    </a>
                    <div class="w-full">
                        <livewire:purchases.create />
                    </div>
                </div>
            </div>
        </header>

        <div class="py-3 px-2">
            {{ $products->links() }}
        </div>

        <section class="px-2 mt-4 rounded-b-lg">
            @forelse($products as $product)
                <div
                    class="py-2 px-4 mb-2 w-full bg-white rounded-md dark:bg-slate-800 dark:even:bg-slate-700 even:bg-slate-50">
                    <div class="grid grid-cols-2 gap-3 lg:grid-cols-8">
                        <div class="col-span-2 w-full text-xs">
                            @if (auth()->user()->hasPermissionTo('edit products'))
                                <a
                                    class="link"
                                    href="{{ route('products/edit', $product->id) }}"
                                >
                                    {{ $product->sku }}
                                </a>
                            @else
                                <p class="text-slate-500 dark:text-slate-400">{{ $product->sku }}</p>
                            @endif
                            <p class="font-semibold text-slate-800 dark:text-slate-300">
                                {{ $product->brand }} {{ $product->name }}
                            </p>
                            <div class="flex items-center space-x-1">
                                @foreach ($product->features as $feature)
                                    <p class="pr-1 text-xs text-slate-500 dark:text-slate-400"> {{ $feature->name }}
                                    </p>
                                @endforeach
                            </div>
                            <p class="font-semibold text-slate-500 dark:text-slate-400">
                                {{ $product->category }}
                            </p>
                            @if (str_contains($product->image, '/storage/images/default-image.png'))
                                <p class="text-xs font-semibold text-pink-800 dark:text-pink-500">
                                    ! featured image not set
                                </p>
                            @endif
                        </div>
                        <div class="w-full h-full">
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">IN STOCK</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->sum('qty') }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">PURCHASED</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->where('type', 'purchase')->sum('qty') }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">CREDITS</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->where('type', 'credit')->sum('qty') }}</p>
                            </div>
                        </div>
                        <div class="w-full h-full">
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">SOLD</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->where('type', 'invoice')->sum('qty') }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">ADJUSTMENTS</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->where('type', 'adjustment')->sum('qty') }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">SUPPLIER CREDITS</p>
                                <p class="text-xs font-semibold text-teal-800 dark:text-teal-500">
                                    {{ $product->stocks->where('type', 'supplier_credit')->sum('qty') }}</p>
                            </div>
                        </div>
                        <div class="w-full h-full">
                            <div>
                                <div>
                                    @if (auth()->user()->hasPermissionTo('edit pricing'))
                                        <x-form.input.label for="retail">
                                            Retail price
                                        </x-form.input.label>

                                        <x-form.input.text
                                            class="px-0.5 w-full rounded border"
                                            id="retail"
                                            type="number"
                                            value="{{ $product->retail_price }}"
                                            inputmode="numeric"
                                            pattern="[0-9]"
                                            step="0.01"
                                            @keydown.tab="$wire.call('updateRetailPrice','{{ $product->id }}',$event.target.value)"
                                        />
                                    @else
                                        <x-form.input.label for="retail">
                                            Retail price
                                        </x-form.input.label>
                                        <p class="text-center text-slate-500 dark:text-slate-400">
                                            {{ $product->retail_price }}</p>
                                    @endif
                                    @if (auth()->user()->hasPermissionTo('view cost'))
                                        <span
                                            class="@if (profit_percentage($product->retail_price, $product->cost) < 0) text-pink-700 @else text-teal-500 @endif text-xs"
                                        >
                                            {{ profit_percentage($product->retail_price, $product->cost) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="w-full h-full">
                            <div>
                                @if (auth()->user()->hasPermissionTo('edit pricing'))
                                    <x-form.input.label for="wholesale">
                                        Wholesale price
                                    </x-form.input.label>
                                    <x-form.input.text
                                        class="px-0.5 w-full rounded border"
                                        id="wholesale"
                                        type="number"
                                        value="{{ $product->wholesale_price }}"
                                        inputmode="numeric"
                                        pattern="[0-9]"
                                        step="0.01"
                                        @keydown.tab="$wire.call('updateWholesalePrice','{{ $product->id }}',$event.target.value)"
                                    />
                                @else
                                    <x-form.input.label for="wholesale">
                                        Wholesale price
                                    </x-form.input.label>
                                    <p class="text-center text-slate-500 dark:text-slate-400">
                                        {{ $product->wholesale_price }}</p>
                                @endif
                                @if (auth()->user()->hasPermissionTo('view cost'))
                                    <span
                                        class="@if (profit_percentage($product->wholesale_price, $product->cost) < 0) text-pink-700 @else text-teal-500 @endif text-xs"
                                    >
                                        {{ profit_percentage($product->wholesale_price, $product->cost) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 w-full h-full">
                            <div>
                                @if ($product->retail_price * $product->wholesale_price > 0)
                                    @if ($product->is_active)
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleActive','{{ $product->id }}')"
                                        >
                                            <x-icons.tick class="w-3 h-3 text-teal-400 dark:text-white" />
                                            <p>active</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleActive','{{ $product->id }}')"
                                        >
                                            <x-icons.cross class="w-3 h-3 text-pink-400 dark:text-pink-400" />
                                            <p>active</p>
                                        </button>
                                    @endif
                                @endif
                            </div>
                            <div>
                                @if ($product->is_featured)
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('toggleFeatured','{{ $product->id }}')"
                                    >
                                        <x-icons.tick class="w-3 h-3 text-teal-400 dark:text-white" />
                                        <p>featured</p>
                                    </button>
                                @else
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('toggleFeatured','{{ $product->id }}')"
                                    >
                                        <x-icons.cross class="w-3 h-3 text-pink-400 dark:text-pink-400" />
                                        <p>featured</p>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 w-full h-full">
                            <div>
                                @if ($product->is_sale)
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('toggleSale','{{ $product->id }}')"
                                    >
                                        <x-icons.tick class="w-3 h-3 text-teal-400 dark:text-white" />
                                        <p>sale</p>
                                    </button>
                                @else
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('toggleSale','{{ $product->id }}')"
                                    >
                                        <x-icons.cross class="w-3 h-3 text-pink-400 dark:text-pink-400" />
                                        <p>sale</p>
                                    </button>
                                @endif
                            </div>
                            <div>
                                @if ($product->trashed())
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('recover','{{ $product->id }}')"
                                    >
                                        <x-icons.tick class="w-3 h-3 text-teal-400 dark:text-white" />
                                        <p>recover</p>
                                    </button>
                                @else
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('delete','{{ $product->id }}')"
                                    >
                                        <x-icons.cross class="w-3 h-3 text-pink-400 dark:text-pink-400" />
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
        </section>
    </div>
</div>
