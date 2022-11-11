<div x-data="{}">
    <x-loading-screen />

    <x-modal
        title="Are you sure?"
        wire:model.defer="showConfirmModal"
    >
        <div class="flex py-4 space-x-4">
            <button
                class="button-success"
                wire:loading.attr="disabled"
                wire:target="process"
                @click="disable(this)"
                x-on:click="$wire.call('process')"
            >
                <x-icons.tick class="mr-2 w-5 h-5" />
                Yes! Process
            </button>
            <button
                class="w-32 button-secondary"
                x-on:click="$wire.set('showConfirmModal',false)"
            >
                <x-icons.cross class="mr-2 w-5 h-5" />
                No
            </button>
        </div>
    </x-modal>

    <div>
        <div class="grid gap-3 py-1 px-2 pb-4 bg-white rounded-md md:grid-cols-4 grid-col-1 dark:bg-slate-900">
            <div class="order-last md:order-first md:col-span-2">
                @if (!$this->credit->processed)
                    <div class="grid grid-cols-1 gap-2 pb-3 lg:grid-cols-2">
                        <button
                            class="w-full button-success"
                            x-on:click="$wire.set('showProductSelectorForm',true)"
                        >
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            add products
                        </button>
                        <div></div>
                        <button
                            class="w-full button-danger"
                            x-on:click="$wire.call('cancel')"
                        >
                            <x-icons.cross class="mr-2 w-5 h-5" />
                            cancel
                        </button>
                        <button
                            class="w-full button-success"
                            x-on:click="$wire.set('showConfirmModal',true)"
                        >
                            <x-icons.tick class="mr-2 w-5 h-5" />
                            process
                        </button>
                    </div>
                @else
                    <div class="pb-3">
                        <button
                            class="w-full button-danger"
                            disabled
                        >Processed by {{ $this->credit->created_by }} on {{ $this->credit->processed_date }}
                        </button>
                    </div>
                @endif
            </div>
            <div class="text-right">
                <h1 class="pl-4 text-4xl font-bold underline underline-offset-4 text-slate-600 dark:text-slate-400">
                    R {{ number_format($this->credit->getTotal(), 2) }}
                </h1>
                <h2>
                    <span class="text-xs text-slate-600 dark:text-slate-400">vat</span>
                    {{ number_format(vat($this->credit->getTotal()), 2) }}
                </h2>
            </div>
            <div class="text-right text-slate-600 dark:text-slate-400">
                <h1 class="text-4xl font-bold">{{ $this->credit->number }}</h1>
                <a
                    class="link"
                    href="{{ route('suppliers/show', $this->supplier->id) }}"
                >{{ $this->supplier->name }}</a>
                <h2>{{ $this->credit->created_at->format('Y-M-d') }}</h2>
            </div>
        </div>

        <x-slide-over
            title="Select products"
            x-cloak
            wire:ignore.self="searchQuery"
            wire:model.defer="showProductSelectorForm"
        >
            <div>
                <x-input
                    type="search"
                    label="search products"
                    wire:model="searchQuery"
                />
            </div>

            <div class="pt-4">
                <form wire:submit.prevent="addProducts">
                    <div class="py-6">
                        <button class="button-success">
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            add
                        </button>
                    </div>
                    <fieldset class="space-y-2">
                        @forelse($products as $product)
                            <label class="flex relative items-start py-2 px-4 rounded-md bg-slate-100">
                                <div>
                                    <input
                                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500 border-slate-300"
                                        id="{{ $product->id }}"
                                        type="checkbox"
                                        value="{{ $product->id }}"
                                        aria-describedby="product"
                                        wire:model="selectedProducts"
                                        wire:key="{{ $product->id }}"
                                    >
                                </div>
                                <div class="flex items-center ml-3 w-full">
                                    <div class="rounded-full">
                                        <img
                                            class="mr-3 w-10 h-10 rounded-full"
                                            src="{{ asset($product->image) }}"
                                            alt=""
                                        >
                                    </div>
                                    <div class="text-sm">
                                        <div
                                            class="font-semibold text-slate-700"
                                            for="{{ $product->id }}"
                                        >
                                            {{ $product->brand }} {{ $product->name }}
                                            <p class="text-xs text-slate-700">{{ $product->sku }}</p>
                                        </div>
                                        <div class="flex flex-wrap items-center divide-x">
                                            @foreach ($product->features as $feature)
                                                <p
                                                    class="px-1 text-xs text-slate-500"
                                                    id="features"
                                                >
                                                    {{ $feature->name }}
                                                </p>
                                            @endforeach
                                        </div>
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
                {{ $products->links() }}
            </div>
        </x-slide-over>

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @foreach ($this->credit->items as $item)
                <div>
                    <div
                        class="grid grid-cols-2 gap-4 py-2 w-full bg-white rounded-md md:grid-cols-5 dark:bg-slate-900">
                        <div class="col-span-2 py-4 px-2">
                            <x-product-listing-simple :product="$item->product" />
                        </div>
                        @if (!$this->credit->processed)
                            <div class="py-4 px-2">
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-700"
                                        type="number"
                                        value="{{ $item->cost }}"
                                        x-on:keydown.enter="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                        x-on:blur="$wire.call('updatePrice',{{ $item->id }},$event.target.value)"
                                    />
                                    <span class="text-xs text-slate-500">Cost</span>
                                </label>
                            </div>
                        @else
                            <div class="py-6 px-2">
                                <p class="font-bold">
                                    {{ number_format($item->price, 2) }}
                                </p>
                            </div>
                        @endif
                        @if (!$this->credit->processed)
                            <div class="py-4 px-2">
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-700"
                                        type="number"
                                        value="{{ $item->qty }}"
                                        x-on:keydown.enter="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                        x-on:blur="$wire.call('updateQty',{{ $item->id }},$event.target.value)"
                                    />
                                    <span class="text-xs text-slate-500">Qty ({{ $item->product->qty() }} in
                                        stock)</span>
                                </label>
                            </div>
                        @else
                            <div class="py-6 px-2">
                                <p class="font-bold text-slate-600 dark:text-slate-400">
                                    {{ $item->qty }}
                                </p>
                            </div>
                        @endif
                        <div class="flex justify-between items-center px-4">
                            <div>
                                <p class="font-bold text-right text-slate-600 dark:text-slate-400">
                                    {{ number_format($item->line_total, 2) }}
                                </p>
                            </div>
                            @if (!$this->credit->processed)
                                <div class="hidden md:block">
                                    <button
                                        class="button-danger"
                                        wire:loading.attr="disabled"
                                        x-on:click="$wire.call('deleteItem','{{ $item->id }}')"
                                    >remove
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="px-2 md:hidden">
                            @if (!$this->credit->processed)
                                <button
                                    class="w-full button-danger"
                                    wire:loading.attr="disabled"
                                    x-on:click="$wire.call('deleteItem','{{ $item->id }}')"
                                >
                                    remove
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        function disable(button) {
            button.disabled = true;
        }
    </script>
</div>
