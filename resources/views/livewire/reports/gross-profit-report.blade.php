<div>
    <div>
        <button
            class="w-full button-success"
            wire:click="$toggle('showGrossProfitReportForm')"
        >
            Gross profit Report
        </button>

        <div class="p-2">
            <p class="text-xs text-slate-500">
                Gross profit report between a specified date by salesperson
            </p>
        </div>
    </div>

    <x-modal x-data="{ show: $wire.entangle('showGrossProfitReportForm') }">
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
