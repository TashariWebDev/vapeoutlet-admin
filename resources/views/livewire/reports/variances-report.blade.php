<div>
    <div>
        <button
            class="w-full button-success"
            wire:click="$toggle('showVariancesForm')"
        >
            Stock Variance Report
        </button>

        <div class="p-2">
            <p class="text-xs text-slate-500">
                Stock variances between a specified date
            </p>
        </div>
    </div>

    <x-modal x-data="{ show: $wire.entangle('showVariancesForm') }">
        <form wire:submit.prevent="print">
            <div class="py-4">
                <x-input.text
                    type="date"
                    label="From date"
                    wire:model.defer="fromDate"
                    required
                />
            </div>

            <div class="py-4">
                <x-input.text
                    type="date"
                    label="To date"
                    wire:model.defer="toDate"
                    required
                />
            </div>

            <div class="py-2">
                <button class="button-success">
                    <x-icons.busy target="print" />
                    Get report
                </button>
            </div>
        </form>
    </x-modal>
</div>
