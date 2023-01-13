<div>

    <button
        class="w-full button-success"
        wire:click.prevent="$toggle('modal')"
    >
        Add products
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Add products</h3>
        </div>
        <div x-data="{ searchQuery: @entangle('searchQuery') }">
            <div class="relative">
                <x-input.label for="search">
                    Product search
                </x-input.label>
                <x-input.text
                    class="w-full"
                    id="search"
                    type="search"
                    x-model.lazy="searchQuery"
                    placeholder="search"
                >
                </x-input.text>

                <div
                    class="absolute top-0 right-0 w-2 h-2 rounded-full ring-1 ring-blue-400 ring-offset-1 animate-ping bg-sky-600"
                    wire:loading="updatedSearchQuery"
                >

                </div>
            </div>
            @if (count($products))
                <div class="p-1">
                    <p class="text-xs font-semibold uppercase text-slate-500"> {{ count($products) }} results</p>
                </div>
            @endif
        </div>

        <div class="pt-4">
            <form wire:submit.prevent="addProducts">
                <div class="py-4">
                    <button class="w-full button-success">
                        <x-icons.plus class="mr-2 w-5 h-5" />
                        add
                    </button>
                </div>
                <fieldset class="space-y-2">
                    @forelse($this->products as $product)
                        <label
                            class="flex relative items-start py-2 px-2 rounded-md bg-slate-100 dark:bg-slate-800"
                            wire:key="'item-'{{ $product->id }}"
                        >
                            <div>
                                <input
                                    class="w-4 h-4 rounded text-sky-600 border-slate-300 focus:ring-sky-500"
                                    id="{{ $product->id }}"
                                    type="checkbox"
                                    value="{{ $product->id }}"
                                    aria-describedby="product"
                                    wire:model.defer="selectedProducts"
                                >
                            </div>
                            <div class="flex justify-between items-center ml-3 w-full">
                                <x-product-listing-simple :product="$product" />

                                <div>
                                    <img
                                        class="w-10"
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
    </x-slide-over>
</div>
