<div>
    <div>
        <button
            class="w-full button-success"
            wire:click="$toggle('showSalesReportForm')"
        >
            Sales Report
        </button>

        <div class="p-2">
            <p class="text-xs text-slate-500">
                Sales report between a specified date by salesperson
            </p>
        </div>
    </div>

    <x-modal x-data="{ show: $wire.entangle('showSalesReportForm') }">
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

            <div class="py-4">
                <x-input.select wire:model.defer="salesperson_id">
                    <option value="">Choose</option>
                    @foreach ($salespeople as $salesperson)
                        <option value="{{ $salesperson->id }}">{{ $salesperson->name }}</option>
                    @endforeach
                </x-input.select>
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
