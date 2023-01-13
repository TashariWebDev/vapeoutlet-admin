<div class="relative">
    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Process this transfer?</h3>
        </div>
        <div class="flex items-center py-3 space-x-2">
            <button
                class="w-32 button-success"
                wire:click="process"
                wire:target="process"
                wire:loading.attr="disabled"
            >
                <span
                    class="pr-2"
                    wire:loading
                ><x-icons.busy target="process" /></span>
                Yes!
            </button>
            <button
                class="w-32 button-danger"
                x-on:click="show = !show"
            >
                No
            </button>
        </div>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-y-2 p-2 lg:grid-cols-3 lg:gap-y-0 lg:gap-x-3">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-sky-400">{{ $stockTransfer->number() }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-500">{{ $stockTransfer->date }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-500">
                    Transferring from {{ $stockTransfer->dispatcher->name }}
                    to {{ $stockTransfer->receiver->name }}
                </p>
                @if ($stockTransfer->is_processed)
                    <p class="text-xs text-yellow-500 dark:text-yellow-400">
                        Processed by {{ $stockTransfer->user->name }} </p>
                    <p class="text-xs text-yellow-500 dark:text-yellow-400">{{ $stockTransfer->updated_at }}</p>
                @endif
            </div>
            <div></div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-2">
                <div>
                    @if (!$stockTransfer->is_processed)
                        <livewire:stock-transfers.add-products :stockTransferId="$stockTransfer->id" />
                    @endif
                </div>

                <div>
                    @if (!$stockTransfer->is_processed)
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
                    @if (!$stockTransfer->is_processed)
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

        @if (!$stockTransfer->is_processed)
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
            <x-table.header class="hidden grid-cols-2 lg:grid">
                <x-table.heading class="col-span-2">Product</x-table.heading>
                <x-table.heading class="lg:text-right">qty to transfer</x-table.heading>
            </x-table.header>
            <div>
                @if (!empty($selectedProductsToDelete))
                    @if (!$stockTransfer->is_processed)
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
            @foreach ($stockTransfer->items as $item)
                <x-table.body
                    class="grid lg:grid-cols-5"
                    wire:key="'item-table-'{{ $item->id }}"
                >
                    <x-table.row class="col-span-2">

                        <div class="flex justify-start items-center">
                            <div>
                                @if (!$stockTransfer->is_processed)
                                    <label
                                        class="hidden"
                                        for="{{ $item->id }}"
                                    ></label>
                                    <input
                                        class="w-4 h-4 rounded bcredit-slate-300 text-sky-600 focus:ring-sky-500"
                                        id="{{ $item->id }}"
                                        type="checkbox"
                                        value="{{ $item->id }}"
                                        aria-describedby="product"
                                        wire:model="selectedProductsToDelete"
                                    >
                                @endif
                            </div>
                            <div>
                                <x-product-listing-simple
                                    :product="$item->product"
                                    wire:key="'stockTransfer-item-'{{ $item->id }}"
                                />
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        @if (!$stockTransfer->is_processed)
                            <form>
                                <label>
                                    <x-input.text
                                        type="number"
                                        value="{{ $item->qty }}"
                                        wire:keyup.debounce.500ms="updateQty({{ $item->id }},$event.target.value,{{ $item->product->total_available }})"
                                        inputmode="numeric"
                                        pattern="[0-9]"
                                        min="1"
                                        max="{{ $item->product->total_available }}"
                                    />
                                </label>
                            </form>
                        @else
                            <label>
                                <x-input.text
                                    type="number"
                                    value="{{ $item->qty }}"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    disabled
                                />
                            </label>
                        @endif
                        @if (!$stockTransfer->is_processed)
                            <div class="flex justify-between items-center mt-1">
                                <div class="text-xs text-rose-700 dark:text-rose-400 hover:text-rose-700">
                                    <button
                                        wire:loading.attr="disabled"
                                        wire:target="removeProducts"
                                        wire:click="deleteItem({{ $item->id }})"
                                    >remove
                                    </button>
                                </div>
                                <div>
                                    {{ $item->product->total_available }} in {{ $stockTransfer->dispatcher->name }}
                                </div>
                            </div>
                        @endif
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
