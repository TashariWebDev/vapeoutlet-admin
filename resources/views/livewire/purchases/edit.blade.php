<div class="relative">
    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
        <x-page-header>
            Are you sure you want to process?
        </x-page-header>
        <div class="flex py-4 space-x-4">
            <button
                class="button-success"
                wire:loading.attr="disabled"
                wire:target="process"
                wire:click="process"
            >
                <x-icons.busy target="process" />
                Yes! Process
            </button>
            <button
                class="w-32 button-danger"
                wire:loading.attr="disabled"
                wire:target="process"
                wire:click="$toggle('showConfirmModal')"
            >
                No
            </button>
        </div>
        <div class="h-10">
            <p
                class="hidden text-xs font-semibold text-rose-600 uppercase"
                wire:target="process"
                wire:loading.class.remove="hidden"
            >
                Processing! This may take a few minutes... please dont close this
                page.
            </p>
        </div>
    </x-modal>

    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-y-2 p-2 lg:grid-cols-3 lg:gap-y-0 lg:gap-x-3">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-sky-400">
                    INVOICE: {{ $this->purchase->invoice_no }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-300">{{ $this->purchase->date }}</p>
                <div class="flex justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Total:
                        <span class="text-sky-600">
                            {{ $this->purchase->total }} {{ $this->purchase->currency }}
                        </span>
                        <span class="font-bold">/ {{ $this->purchase->amount }}
                            {{ $this->purchase->currency }}</span>
                    </p>
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Count: {{ $this->purchase->items_count }}
                    </p>
                </div>
                <div class="flex px-2 space-x-2 text-xs text-slate-500">
                    @if ($this->purchase->taxable)
                        <p>vat {{ number_format(vat($this->purchase->amount), 2) }}</p>
                    @endif
                    @if ($this->purchase->shipping_rate)
                        <p>shipping {{ $this->purchase->shipping_rate }} %</p>
                    @endif
                    @if ($this->purchase->exchange_rate)
                        <p>exchange R {{ number_format($this->purchase->exchange_rate, 2) }}</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 text-xs lg:grid-cols-2">
                <div>
                    @if ($this->purchase->processed)
                        <a
                            class="link"
                            href="{{ route('suppliers/show', $this->purchase->supplier_id) }}"
                        >
                            {{ $this->purchase->supplier->name }}
                        </a>
                    @else
                        <p class="font-semibold text-slate-600 dark:text-slate-300">
                            {{ $this->purchase->supplier->name }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-2">
                @if ($this->purchase->processed)
                    <div>
                        <button
                            class="w-full button-warning"
                            disabled
                        >
                            <p>Processed by {{ $this->purchase->creator->name }} </p>
                            <p>{{ $this->purchase->processed_date }}</p>
                        </button>
                    </div>
                @endif
                <div>
                    @if (!$this->purchase->processed)
                        <livewire:purchases.add-product :purchase="$this->purchase" />
                    @endif
                </div>

                <div>
                    @if (!$this->purchase->processed)
                        <button
                            class="w-full button-danger"
                            wire:click="cancel"
                        >
                            <x-icons.busy target="cancel" />
                            cancel
                        </button>
                    @endif
                </div>
                <div>
                    @if (!$this->purchase->processed)
                        <livewire:products.create />
                    @endif
                </div>

                <div>
                    @if (!$this->purchase->processed)
                        <button
                            class="w-full button-success"
                            wire:click="$toggle('showConfirmModal')"
                        >
                            <x-icons.busy target="process" />
                            process
                        </button>
                    @endif
                </div>

            </div>
        </div>

        @if (!$this->purchase->processed)
            <div class="py-0.5 px-2 w-full">
                <div>
                    <x-input.text
                        type="text"
                        placeholder="SKU"
                        autofocus
                        wire:model="sku"
                    >
                    </x-input.text>
                </div>
            </div>
        @endif

        <x-table.container>
            <x-table.header class="hidden grid-cols-5 lg:grid">
                <x-table.heading class="col-span-2">Product</x-table.heading>
                <x-table.heading class="lg:text-right">price</x-table.heading>
                <x-table.heading class="lg:text-right">qty</x-table.heading>
                <x-table.heading class="lg:text-right">Line total</x-table.heading>
            </x-table.header>
            <div>
                @if (!empty($selectedProductsToDelete))
                    @if (!$this->purchase->processed)
                        <div>
                            <button
                                class="text-xs text-rose-700 dark:text-rose-400 hover:text-rose-700"
                                x-on:click="$wire.call('removeProducts')"
                            >remove selected items
                            </button>
                        </div>
                    @endif
                @endif
            </div>
            @foreach ($this->purchase->items as $item)
                <x-table.body
                    class="grid lg:grid-cols-5"
                    wire:key="'item-table-'{{ $item->id }}"
                >
                    <x-table.row class="col-span-2">
                        <div class="flex justify-start items-center">
                            @if (!$this->purchase->processed)
                                <div>
                                    <label
                                        class="hidden"
                                        for="{{ $item->id }}"
                                    ></label>
                                    <input
                                        class="w-4 h-4 rounded text-sky-600 bg-slate-300 focus:ring-sky-500"
                                        id="{{ $item->id }}"
                                        type="checkbox"
                                        value="{{ $item->id }}"
                                        aria-describedby="product"
                                        wire:model="selectedProductsToDelete"
                                    >
                                </div>
                            @endif
                            <div>
                                <x-product-listing-simple
                                    :product="$item->product"
                                    wire:key="'credit-item-'{{ $item->id }}"
                                />
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        @if (!$this->purchase->processed)
                            <form>
                                <label>
                                    <x-input.text
                                        type="number"
                                        value="{{ $item->price }}"
                                        wire:keyup.debounce.500ms="updatePrice({{ $item->id }},$event.target.value)"
                                        pattern="[0-9]*"
                                        inputmode="numeric"
                                        step="0.01"
                                    />
                                </label>
                            </form>
                        @else
                            <label>
                                <x-input.text
                                    type="number"
                                    value="{{ $item->price }}"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    step="0.01"
                                    disabled
                                />
                            </label>
                        @endif
                    </x-table.row>
                    <x-table.row>
                        @if (!$this->purchase->processed)
                            <form>
                                <label>
                                    <x-input.text
                                        type="number"
                                        value="{{ $item->qty }}"
                                        wire:keyup.debounce.500ms="updateQty({{ $item->id }},$event.target.value)"
                                        inputmode="numeric"
                                        pattern="[0-9]"
                                        min="1"
                                        max="{{ $item->product->qty() }}"
                                    />
                                </label>
                            </form>
                        @else
                            <label>
                                <x-input.text
                                    type="number"
                                    value="{{ $item->qty }}"
                                    disabled
                                />
                            </label>
                        @endif
                        <div class="flex justify-between items-center mt-1">
                            <div class="text-xs text-rose-700 dark:text-rose-400 hover:text-rose-700">
                                @if (!$this->purchase->processed)
                                    <button
                                        wire:loading.attr="disabled"
                                        wire:target="removeProducts"
                                        wire:click="deleteItem('{{ $item->id }}')"
                                    >remove
                                    </button>
                                @endif
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->line_total }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
