<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('slide')"
    >
        New purchase
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <form wire:submit.prevent="save">
            <div class="relative">
                <div class="flex items-end py-2">
                    <div class="flex-1">
                        <x-form.input.label for="supplier">
                            Select a supplier
                        </x-form.input.label>
                        <x-form.input.select
                            id="supplier"
                            wire:model.defer="supplier_id"
                        >
                            <option value="">Choose</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </x-form.input.select>
                        @error('supplier_id')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div>
                        <livewire:suppliers.create />
                    </div>
                </div>

            </div>
            <div class="py-2">
                <x-form.input.label for="date">
                    date
                </x-form.input.label>
                <x-form.input.text
                    id="date"
                    type="date"
                    wire:model.defer="date"
                />
                @error('date')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="invoice_no">
                    Invoice no
                </x-form.input.label>
                <x-form.input.text
                    id="invoice_no"
                    type="text"
                    wire:model.defer="invoice_no"
                />
                @error('invoice_no')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="relative py-2">
                <x-form.input.label for="currency">
                    currency
                </x-form.input.label>
                <x-form.input.select
                    id="currency"
                    wire:model.defer="currency"
                >
                    <option value="ZAR">ZAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="CNH">CNH</option>
                </x-form.input.select>
                @error('currency')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="exchange_rate">
                    exchange rate in ZAR ( optional )
                </x-form.input.label>
                <x-form.input.text
                    id="exchange_rate"
                    type="number"
                    wire:model.defer="exchange_rate"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('exchange_rate')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="amount">
                    Invoice amount in selected currency ( ex shipping )
                </x-form.input.label>
                <x-form.input.text
                    id="amount"
                    type="number"
                    wire:model.defer="amount"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('amount')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="shipping_rate">
                    Shipping rate as % ( optional )
                </x-form.input.label>
                <x-form.input.text
                    id="shipping_rate"
                    type="number"
                    wire:model.defer="shipping_rate"
                    autocomplete="off"
                    wire:keydown.enter.prevent
                    step="0.01"
                    inputmode="numeric"
                    pattern="[0-9.]+"
                />
                @error('shipping_rate')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2 px-2 mt-2 rounded-md text-slate-600 bg-slate-100 dark:text-slate-400 dark:bg-slate-700">
                <label
                    class="flex items-center space-x-2 text-xs font-medium uppercase"
                    for="taxable"
                >
                    <input
                        class="text-teal-500 rounded-full focus:ring-slate-200"
                        id="taxable"
                        type="checkbox"
                        wire:model.defer="taxable"
                    />
                    <span class="ml-3">Taxable</span>
                </label>
                @error('taxable')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2 mt-2">
                <button class="button-success">
                    save
                </button>
            </div>
        </form>
    </x-slide-over>
</div>
