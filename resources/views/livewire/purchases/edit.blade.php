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
                class="hidden text-xs font-semibold text-pink-600 uppercase"
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
                <p class="text-xs font-bold dark:text-teal-400 text-slate-500">
                    INVOICE: {{ $this->purchase->invoice_no }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $this->purchase->date }}</p>
                <div class="flex justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Total:
                        <span class="@if ($this->purchase->total === $this->purchase->amount) text-teal-600 @else text-pink-600 @endif">
                            {{ $this->purchase->total }} {{ $this->purchase->currency }}
                        </span>
                        <span class="font-bold">/ {{ $this->purchase->amount }}
                            {{ $this->purchase->currency }}</span>
                    </p>
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Count: {{ $this->purchase->items_count }}
                    </p>
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
                        <p class="font-semibold text-slate-500 dark:text-slate-400">
                            {{ $this->purchase->supplier->name }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-2">
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
                    @if ($this->purchase->processed)
                        <button
                            class="w-full button-warning"
                            disabled
                        >
                            <p>Processed by {{ $this->purchase->creator->name }} </p>
                            <p>{{ $this->purchase->processed_date }}</p>
                        </button>
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
                    <x-form.input.text
                        type="text"
                        placeholder="SKU"
                        autofocus
                        wire:model="sku"
                    >
                    </x-form.input.text>
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
                                class="text-xs text-pink-700 dark:text-pink-400 hover:text-pink-700"
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
                                        class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500 bg-slate-300"
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
                            <form
                                x-on:keydown.tab="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                                x-on:keydown.enter="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                            >
                                <label>
                                    <x-form.input.text
                                        type="number"
                                        value="{{ $item->price }}"
                                        pattern="[0-9]*"
                                        inputmode="numeric"
                                        step="0.01"
                                    />
                                </label>
                            </form>
                        @else
                            <label>
                                <x-form.input.text
                                    type="number"
                                    value="{{ $item->price }}"
                                    disabled
                                />
                            </label>
                        @endif
                    </x-table.row>
                    <x-table.row>
                        @if (!$this->purchase->processed)
                            <form
                                x-on:keydown.tab="@this.call('updateQty',{{ $item->id }},$event.target.value)"
                                x-on:keydown.enter="@this.call('updateQty',{{ $item->id }},$event.target.value)"
                            >
                                <label>
                                    <x-form.input.text
                                        type="number"
                                        value="{{ $item->qty }}"
                                        pattern="[0-9]*"
                                        inputmode="numeric"
                                        min="1"
                                        max="{{ $item->product->qty() }}"
                                    />
                                </label>
                            </form>
                        @else
                            <label>
                                <x-form.input.text
                                    type="number"
                                    value="{{ $item->qty }}"
                                    disabled
                                />
                            </label>
                        @endif
                        <div class="flex justify-between items-center mt-1">
                            <div class="text-xs text-pink-700 dark:text-pink-400 hover:text-pink-700">
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
                            <x-form.input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->line_total }}"
                                disabled
                            />
                        </label>
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
