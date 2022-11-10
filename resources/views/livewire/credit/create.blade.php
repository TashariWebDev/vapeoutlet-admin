<div x-data="{}">

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
                Yes! Process,
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
                            x-on:click="$wire.set('showProductSelectorForm', true)"
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
                        >Processed by {{ $this->credit->created_by }} on
                            {{ $this->credit->processed_date }}
                        </button>
                    </div>
                @endif
            </div>
            <div class="text-right">
                <h1 class="pl-4 text-4xl font-bold underline underline-offset-4 text-slate-600 dark:text-slate-400">
                    R {{ number_format($this->credit->getTotal(), 2) }}
                </h1>
                <h2 class="text-slate-600 dark:text-slate-400">
                    <span class="text-xs">vat</span> {{ number_format(vat($this->credit->getTotal()), 2) }}
                </h2>
            </div>
            <div class="text-right text-slate-600 dark:text-slate-400">
                <h1 class="text-4xl font-bold">{{ $this->credit->number }}</h1>
                <a
                    class="link"
                    href="{{ route('customers/show', $this->customer->id) }}"
                >{{ $this->customer->name }}</a>
                <h2>{{ $this->credit->created_at->format('Y-M-d') }}</h2>
            </div>
        </div>

        <x-slide-over
            title="Select products"
            x-cloak
            wire:ignore.self="searchQuery"
            wire:model.defer="showProductSelectorForm"
        >
            <div x-data="{ searchQuery: @entangle('searchQuery') }">
                <div class="relative">
                    <label>
                        <input
                            class="w-full rounded-md border-2 border-yellow-400 focus:ring-2 placeholder-slate-300"
                            type="search"
                            x-model.lazy="searchQuery"
                            placeholder="search"
                        >
                    </label>
                    <div
                        class="absolute top-0 right-0 w-2 h-2 bg-green-600 rounded-full ring-1 ring-blue-400 ring-offset-1 animate-ping"
                        wire:loading="updatedSearchQuery"
                    >

                    </div>
                </div>
                @if (count($products))
                    <div class="p-1">
                        <p class="text-xs font-semibold uppercase"> {{ count($products) }} results</p>
                    </div>
                @endif
            </div>

            <div class="pt-4">
                <form wire:submit.prevent="addProducts">
                    <div class="py-6">
                        <button class="w-full button-success">
                            <x-icons.plus class="mr-2 w-5 h-5" />
                            add
                        </button>
                    </div>
                    <fieldset class="space-y-2">
                        @forelse($this->products as $product)
                            <label
                                class="flex relative items-start py-2 px-4 rounded-md bg-slate-100"
                                wire:key="'item-'{{ $product->id }}"
                            >
                                <div>
                                    <input
                                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500 border-slate-300"
                                        id="{{ $product->id }}"
                                        type="checkbox"
                                        value="{{ $product->id }}"
                                        aria-describedby="product"
                                        wire:model.defer="selectedProducts"
                                    >
                                </div>
                                <div class="flex items-center ml-3 w-full lg:justify-between">
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

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @foreach ($this->credit->items as $item)
                <div>
                    <div
                        class="grid grid-cols-2 gap-4 py-2 w-full bg-white rounded-md md:grid-cols-5 dark:bg-slate-900">
                        <div class="col-span-2 py-4 px-2 text-slate-600 dark:text-slate-400">
                            <h4 class="font-bold">
                                {{ $item->product->brand }} {{ $item->product->name }}
                            </h4>
                            <div class="flex flex-wrap items-center space-x-1 divide-x">
                                @foreach ($item->product->features as $feature)
                                    <p class="px-0.5 text-xs text-slate-600"> {{ $feature->name }}</p>
                                @endforeach
                            </div>
                            <p class="text-xs text-slate-400">{{ $item->product->sku }}</p>
                        </div>
                        @if (!$this->credit->processed)
                            <div class="py-4 px-2">
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-600"
                                        type="number"
                                        value="{{ $item->price }}"
                                        x-on:keydown.enter="$wire.call('updatePrice','{{ $item->id }}',$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updatePrice','{{ $item->id }}',$event.target.value)"
                                        x-on:blur="$wire.call('updatePrice','{{ $item->id }}',$event.target.value)"
                                    />
                                </label>
                            </div>
                        @else
                            <div class="py-6 px-2">
                                <p class="font-bold text-slate-600 dark:text-slate-400">
                                    {{ number_format($item->price, 2) }}
                                </p>
                            </div>
                        @endif
                        @if (!$this->credit->processed)
                            <div class="py-4 px-2">
                                <label>
                                    <input
                                        class="w-full rounded-md text-slate-600"
                                        type="number"
                                        value="{{ $item->qty }}"
                                        x-on:keydown.enter="$wire.call('updateQty','{{ $item->id }}',$event.target.value)"
                                        x-on:keydown.tab="$wire.call('updateQty','{{ $item->id }}',$event.target.value)"
                                        x-on:blur="$wire.call('updateQty','{{ $item->id }}',$event.target.value)"
                                    />
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
