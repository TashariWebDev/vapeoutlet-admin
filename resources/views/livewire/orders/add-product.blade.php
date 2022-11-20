<div>

    <button
        class="w-full button-success"
        wire:click.prevent="$toggle('modal')"
    >
        Add products
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Add products</h3>
        </div>
        <div>
            <div class="relative">
                <x-form.input.label for="search">
                    Product search
                </x-form.input.label>
                <x-form.input.text
                    class="w-full"
                    id="search"
                    type="search"
                    wire:model="searchQuery"
                    placeholder="search"
                >
                </x-form.input.text>
            </div>
        </div>

        <div class="pt-4">
            <div class="py-2">
                {{ $products->links() }}
            </div>
            <form wire:submit.prevent="addProducts">
                <div class="py-4">
                    <button class="w-full button-success">
                        <x-icons.plus class="mr-2 w-5 h-5" />
                        add
                    </button>
                </div>
                <fieldset class="space-y-2">
                    @forelse($products as $product)
                        <label
                            class="flex relative items-start py-2 px-2 rounded-md bg-slate-100 dark:bg-slate-800"
                            wire:key="'item-'{{ $product->id }}"
                        >
                            <div>
                                <input
                                    class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500 border-slate-300"
                                    id="{{ $product->id }}"
                                    type="checkbox"
                                    value="{{ $product->id }}"
                                    aria-describedby="product"
                                    wire:model.defer="selectedProducts"
                                >
                            </div>
                            <div class="flex justify-between items-center ml-3 w-full">
                                <x-product-listing-simple :product="$product" />
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
