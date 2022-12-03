<div>
    <div>
        <button
            class="w-full button-success"
            wire:click="$toggle('showPurchasesForm')"
        >
            Purchase Report
        </button>

        <div class="p-2">
            <p class="text-xs text-slate-500">
                Purchase report between a specified date range by supplier
            </p>
        </div>
    </div>

    <x-modal x-data="{ show: $wire.entangle('showPurchasesForm') }">
        <form wire:submit.prevent="print">
            <div class="py-4">
                <x-input.text
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                />
            </div>

            <div class="py-4">
                <x-input.text
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                />
            </div>

            <div class="py-4">
                <x-input.select wire:model.defer="supplier">
                    <option value="">Choose</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </x-input.select>
            </div>

            <div class="py-2">
                <button class="button-success">
                    <x-icons.busy target="print" />
                    <span class="pl-2">Get report</span>
                </button>
            </div>
        </form>
    </x-modal>
</div>
