<div>
    <div class="py-3 bg-white rounded-lg shadow dark:bg-slate-900">

        <header class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-2 lg:gap-x-3">

            <div class="grid grid-cols-1 gap-2 py-2 lg:grid-cols-2">
                <div>
                    <x-input.label for="search">
                        Search
                    </x-input.label>
                    <x-input.text
                        class="w-full"
                        id="search"
                        type="search"
                        wire:model="searchQuery"
                        autofocus
                        autocomplete="off"
                        placeholder="Search by SKU, name, category or brand"
                    />
                    <x-input.helper>
                        Query Time {{ round($queryTime, 3) }} ms
                    </x-input.helper>
                </div>

                <div>
                    <x-input.label>
                        No of records
                    </x-input.label>
                    <x-input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-input.select>
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
                    @if ($activeFilter)
                        <button
                            class="w-full button-success"
                            wire:click="toggleFilter"
                        >
                            show disabled products
                        </button>
                    @else
                        <button
                            class="w-full button-success"
                            wire:click="toggleFilter"
                        >
                            show enabled products
                        </button>
                    @endif
                </div>
                <div class="grid grid-cols-1 gap-2">
                    @hasPermissionTo('create purchase')
                    <a
                        class="w-full button-success"
                        href="{{ route('suppliers') }}"
                    >
                        suppliers
                    </a>
                    <div class="w-full">
                        <livewire:purchases.create wire:key="supplier-create" />
                    </div>
                    @endhasPermissionTo
                </div>
            </div>
        </header>

        <div class="py-3 px-2">
            {{ $products->links() }}
        </div>

        <section class="py-6 px-2 rounded-b-lg">
            @forelse($products as $product)

                <div @class([
            'py-6 px-4 mb-2 w-full bg-transparent border-b border-slate-100 dark:border-slate-800',
            'bg-rose-300' => $product->trashed(),
        ])>
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
                                <p class="text-slate-600 dark:text-slate-300">{{ $product->sku }}</p>
                            @endif
                            <p class="font-semibold dark:text-white text-slate-800">
                                {{ $product->brand }} {{ $product->name }}
                            </p>
                            <div class="flex items-center space-x-1">
                                @foreach ($product->features as $feature)
                                    <p class="pr-1 font-semibold uppercase dark:text-white text-[10px] text-slate-800"> {{ $feature->name }}
                                    </p>
                                @endforeach
                            </div>
                            <p class="pr-1 font-semibold uppercase dark:text-white text-[10px] text-slate-800">
                                {{ $product->category }}
                            </p>
                            <p class="pr-1 font-semibold uppercase dark:text-white text-[10px] text-slate-800">
                                ID: {{ $product->id }}
                            </p>
                            @if (!file_exists(public_path('storage/' . $product->image)))
                                <p class="inline-flex items-center py-1 px-2 mt-2 font-medium text-rose-500 rounded-md ring-1 ring-inset dark:text-rose-400 text-[10px] bg-rose-400/10 ring-rose-400/50 dark:ring-rose-400/20">
                                    ! featured image not set
                                </p>
                            @endif
                        </div>
                        <div class="w-full h-full">
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help"
                                   title="Total Sales - Total Sold + Total Credits - Total Supplier Credits + Adjustments"
                                >
                                    IN STOCK
                                </p>
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-500">
                                    {{ $product->total_available }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help">
                                    PURCHASED</p>
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-500">
                                    {{ $product->total_purchases }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help"
                                   title="Total Customer Returns or Cancellations"
                                >

                                    CREDITS
                                </p>
                                <p class="text-xs font-semibold text-slate-800 cursor-help dark:text-slate-500"
                                >
                                    {{ $product->total_credits }}
                                </p>
                            </div>
                            @if (auth()->user()->hasPermissionTo('view cost'))
                                <div class="flex justify-between">
                                    <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help">
                                        AVE COST</p>
                                    <p @class([
                      'text-xs font-semibold text-slate-800 dark:text-slate-500',
                      'text-xs font-semibold text-green-800 dark:text-green-500' =>
                          $product->cost > $product->lastPurchasePrice?->price,
                      'text-xs font-semibold text-rose-800 dark:text-rose-600' =>
                          $product->cost < $product->lastPurchasePrice?->price,
                  ])>
                                        {{ number_format($product->cost, 2) }}
                                    </p>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <a
                                    class="link"
                                    href="{{ route('products/tracking', $product->id) }}"
                                >
                                    Stock tracking
                                </a>
                            </div>
                        </div>
                        <div class="w-full h-full">
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help"
                                   title="Total Sold + Credits"
                                >
                                    SOLD
                                </p>
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help">
                                    {{ $product->total_sold + $product->total_credits }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help"
                                   title="Total Stock Adjustments"
                                >
                                    ADJUSTMENTS
                                </p>
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-500">
                                    {{ $product->total_adjustments }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help"
                                   title="Total Returned to supplier"
                                >
                                    SUPPLIER CREDITS
                                </p>
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-500">
                                    {{ $product->total_supplier_credits }}</p>
                            </div>
                            @if (auth()->user()->hasPermissionTo('view cost'))
                                <div class="flex justify-between">
                                    <p class="font-semibold uppercase dark:text-white text-[10px] text-slate-800 cursor-help">
                                        LAST COST</p>
                                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        {{ number_format($product->getLastCost(), 2) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="w-full h-full">
                            <div>
                                <div>
                                    @if (!$product->trashed())
                                        @if (auth()->user()->hasPermissionTo('edit pricing'))
                                            <x-input.label for="retail">
                                                Retail price
                                            </x-input.label>

                                            <x-input.text
                                                class="px-0.5 w-full rounded border"
                                                id="retail"
                                                type="number"
                                                value="{{ $product->retail_price }}"
                                                inputmode="numeric"
                                                pattern="[0-9]"
                                                step="0.01"
                                                wire:keyup.debounce.1500ms="updateRetailPrice({{ $product->id }},$event.target.value)"
                                            />
                                        @else
                                            <x-input.label for="retail">
                                                Retail price
                                            </x-input.label>
                                            <p class="text-center text-slate-600 dark:text-slate-300">
                                                {{ $product->retail_price }}</p>
                                        @endif
                                        @if (auth()->user()->hasPermissionTo('view cost'))
                                            <span
                                                class="@if (profit_percentage($product->retail_price, $product->cost) < 0) text-rose-700 @else text-blue-500 @endif text-xs"
                                            >
                        {{ profit_percentage($product->retail_price, $product->cost) }}
                      </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="w-full h-full">
                            <div>
                                @if (!$product->trashed())
                                    @if (auth()->user()->hasPermissionTo('edit pricing'))
                                        <x-input.label for="wholesale">
                                            Wholesale price
                                        </x-input.label>
                                        <x-input.text
                                            class="px-0.5 w-full rounded border"
                                            id="wholesale"
                                            type="number"
                                            value="{{ $product->wholesale_price }}"
                                            inputmode="numeric"
                                            pattern="[0-9]"
                                            step="0.01"
                                            wire:keyup.debounce.1500ms="updateWholesalePrice({{ $product->id }},$event.target.value)"
                                        />
                                    @else
                                        <x-input.label for="wholesale">
                                            Wholesale price
                                        </x-input.label>
                                        <p class="text-center text-slate-600 dark:text-slate-300">
                                            {{ $product->wholesale_price }}
                                        </p>
                                    @endif
                                    @if (auth()->user()->hasPermissionTo('view cost'))
                                        <span
                                            class="@if (profit_percentage($product->wholesale_price, $product->cost) < 0) text-rose-700 @else text-blue-500 @endif text-xs"
                                        >
                      {{ profit_percentage($product->wholesale_price, $product->cost) }}
                    </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 w-full h-full">
                            <div>
                                @if (!$product->trashed())
                                    @hasPermissionTo('edit products')
                                    @if ($product->retail_price * $product->wholesale_price > 0)
                                        @if ($product->is_active)
                                            <button
                                                class="flex justify-start items-center space-x-2 w-full button-success"
                                                x-on:click="$wire.call('toggleActive','{{ $product->id }}')"
                                            >
                                                <x-icons.tick class="w-3 h-3 text-blue-500 dark:text-white" />
                                                <p>active</p>
                                            </button>
                                        @else
                                            <button
                                                class="flex justify-start items-center space-x-2 w-full button-danger"
                                                x-on:click="$wire.call('toggleActive','{{ $product->id }}')"
                                            >
                                                <x-icons.cross class="w-3 h-3 text-rose-400 dark:text-rose-400" />
                                                <p>not active</p>
                                            </button>
                                        @endif
                                    @endif
                                    @endhasPermissionTo
                                @endif
                            </div>
                            <div>
                                @if (!$product->trashed())
                                    @hasPermissionTo('edit products')
                                    @if ($product->is_featured)
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleFeatured','{{ $product->id }}')"
                                        >
                                            <x-icons.tick class="w-3 h-3 text-blue-500 dark:text-white" />
                                            <p>featured</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleFeatured','{{ $product->id }}')"
                                        >
                                            <x-icons.cross class="w-3 h-3 text-rose-400 dark:text-rose-400" />
                                            <p>Not featured</p>
                                        </button>
                                    @endif
                                    @endhasPermissionTo
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 w-full h-full">
                            @if (!$product->trashed())
                                <div>
                                    @hasPermissionTo('edit products')
                                    @if ($product->is_sale)
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleSale','{{ $product->id }}')"
                                        >
                                            <x-icons.tick class="w-3 h-3 text-blue-500 dark:text-white" />
                                            <p>sale</p>
                                        </button>
                                    @else
                                        <button
                                            class="flex justify-start items-center space-x-2 w-full button-success"
                                            x-on:click="$wire.call('toggleSale','{{ $product->id }}')"
                                        >
                                            <x-icons.cross class="w-3 h-3 text-rose-400 dark:text-rose-400" />
                                            <p>not on sale</p>
                                        </button>
                                    @endif
                                    @endhasPermissionTo
                                </div>
                            @endif
                            <div>
                                @hasPermissionTo('edit products')
                                @if ($product->trashed())
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-danger"
                                        x-on:click="$wire.call('recover','{{ $product->id }}')"
                                    >
                                        <x-icons.cross class="w-3 h-3 text-rose-400 dark:text-rose-400" />
                                        <p>disabled</p>
                                    </button>
                                @else
                                    <button
                                        class="flex justify-start items-center space-x-2 w-full button-success"
                                        x-on:click="$wire.call('delete','{{ $product->id }}')"
                                    >
                                        <x-icons.tick class="w-3 h-3 text-blue-500 dark:text-white" />
                                        <p>enabled</p>
                                    </button>
                                @endif
                                @endhasPermissionTo
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
