<div class="relative">
    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
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
                class="w-32 button-danger"
                x-on:click="$wire.set('showConfirmModal',false)"
            >
                <x-icons.cross class="mr-2 w-5 h-5" />
                No
            </button>
        </div>
    </x-modal>
    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Process this credit note?</h3>
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
                <p class="text-xs font-bold dark:text-teal-400 text-slate-500">{{ $this->credit->number }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $this->credit->updated_at }}</p>
                <div class="flex justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Total: R {{ number_format($this->credit->getTotal(), 2) }}
                    </p>
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Count: {{ $this->credit->items_count }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 text-xs lg:grid-cols-2">
                <div>
                    <p class="font-semibold text-teal-500 dark:text-teal-400">{{ $this->credit->supplier->name }}
                        @isset($this->credit->supplier->company)
                            <span>| {{ $this->credit->supplier->company }}</span>
                        @endisset
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-2">
                <div>
                    @if (!$this->credit->processed)
                        <livewire:supplier-credits.add-product :credit="$this->credit" />
                    @endif
                </div>

                <div>
                    @if (!$this->credit->processed)
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
                    @if ($this->credit->processed)
                        <button
                            class="w-full button-warning"
                            disabled
                        >
                            <p>Processed by {{ $this->credit->created_by }} </p>
                            <p>{{ $this->credit->processed_date }}</p>
                        </button>
                    @endif
                </div>
                <div>
                    @if (!$this->credit->processed)
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

        @if (!$this->credit->processed)
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
                <x-table.heading class="lg:text-right">cost</x-table.heading>
                <x-table.heading class="lg:text-right">qty</x-table.heading>
                <x-table.heading class="lg:text-right">Line total</x-table.heading>
            </x-table.header>
            <div>
                @if (!empty($selectedProductsToDelete))
                    @if (!$this->credit->processed)
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
            @foreach ($this->credit->items as $item)
                <x-table.body
                    class="grid lg:grid-cols-5"
                    wire:key="'item-table-'{{ $item->id }}"
                >
                    <x-table.row class="col-span-2">
                        <div class="flex justify-start items-center">
                            <div>
                                <label
                                    class="hidden"
                                    for="{{ $item->id }}"
                                ></label>
                                <input
                                    class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500 bcredit-slate-300"
                                    id="{{ $item->id }}"
                                    type="checkbox"
                                    value="{{ $item->id }}"
                                    aria-describedby="product"
                                    wire:model="selectedProductsToDelete"
                                >
                            </div>
                            <div>
                                <x-product-listing-simple
                                    :product="$item->product"
                                    wire:key="'credit-item-'{{ $item->id }}"
                                />
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        @if (!$this->credit->processed)
                            <form
                                x-on:keydown.tab="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                                x-on:keydown.enter="@this.call('updatePrice',{{ $item->id }},$event.target.value)"
                            >
                                <label>
                                    <x-form.input.text
                                        type="number"
                                        value="{{ $item->cost }}"
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
                                    value="{{ $item->cost }}"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    step="0.01"
                                    disabled
                                />
                            </label>
                        @endif
                    </x-table.row>
                    <x-table.row>
                        @if (!$this->credit->processed)
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
                                @if (!$this->credit->processed)
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
