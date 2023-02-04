<div>

    <button
        class="w-full button-success"
        wire:click.prevent="$toggle('modal')"
    >
        Add products
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Add products</h3>
        </div>

        <div>
            <div class="relative">
                <x-input.label for="searchQuery">
                    Product search
                </x-input.label>
                <x-input.text
                    type="search"
                    wire:model="searchQuery"
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
                        <label class="flex relative items-start py-2 px-4 rounded-md bg-slate-300 dark:bg-slate-800">
                            <div>
                                <input
                                    class="w-4 h-4 rounded text-sky-600 border-slate-300 focus:ring-sky-500"
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
    </x-slide-over>
</div>
