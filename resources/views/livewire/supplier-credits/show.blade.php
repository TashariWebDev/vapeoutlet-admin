<div class="relative">
    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-y-2 p-2 lg:grid-cols-3 lg:gap-y-0 lg:gap-x-3">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-sky-400">{{ $this->credit->number }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-500">{{ $this->credit->updated_at }}</p>
                <div class="flex justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Total: R {{ number_format($this->credit->getTotal(), 2) }}
                    </p>
                    <p class="text-xs font-bold text-sky-500 dark:text-sky-400">
                        Count: {{ $this->credit->items->count() }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 text-xs lg:grid-cols-2">
                <div>
                    <p class="font-semibold text-sky-500 dark:text-sky-400">{{ $this->credit->supplier->name }}
                        @isset($this->credit->supplier->company)
                            <span>| {{ $this->credit->supplier->company }}</span>
                        @endisset
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-2">

                <div>
                    <button
                        class="w-full button-warning"
                        disabled
                    >
                        <p>Processed by {{ $this->credit->created_by }} </p>
                        <p>{{ $this->credit->processed_date }}</p>
                    </button>
                </div>
                <div>

                </div>

            </div>
        </div>

        <x-table.container>
            <x-table.header class="hidden grid-cols-5 lg:grid">
                <x-table.heading class="col-span-2">Product</x-table.heading>
                <x-table.heading class="lg:text-right">cost</x-table.heading>
                <x-table.heading class="lg:text-right">qty</x-table.heading>
                <x-table.heading class="lg:text-right">Line total</x-table.heading>
            </x-table.header>

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
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->cost }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-700 bg-slate-400"
                                type="number"
                                value="{{ $item->qty }}"
                                disabled
                            />
                        </label>
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
