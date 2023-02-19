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
        <x-input.label for="search">
          Product search
        </x-input.label>
        <x-input.text
          class="w-full"
          id="search"
          type="search"
          wire:model="searchQuery"
          placeholder="search"
        >
        </x-input.text>
        <x-input.helper>
          Query Time {{ round($queryTime, 3) }} ms
        </x-input.helper>
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
            >
              <div>
                <input
                  class="w-4 h-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                  id="{{ $product->id }}"
                  type="checkbox"
                  value="{{ $product->id }}"
                  aria-describedby="product"
                  wire:model.defer="selectedProducts"
                  wire:key="'item-'{{ $product->id }}"
                >
              </div>
              <div class="flex justify-between items-center ml-3 w-full">
                <x-product-listing-simple :product="$product" />

                <div class="flex items-center space-x-4">
                  <div>
                    <p class="text-xs font-medium text-slate-600 dark:text-slate-300">
                      {{ $product->total_available }} in stock
                    </p>
                  </div>
                  <div>
                    <img
                      class="w-10 h-10"
                      src="{{ asset($product->image) }}"
                      alt=""
                    >
                  </div>
                </div>
              </div>
            </label>
          @empty
            <div
              class="flex inset-0 justify-center items-center py-6 px-2 w-full text-center rounded-md bg-slate-100"
            >
              <p>No results</p>
            </div>
          @endforelse
        </fieldset>
      </form>
    </div>
  </x-slide-over>
</div>
