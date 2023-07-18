<div>
    <div>
        <button
            class="w-full button-success"
            wire:click="$toggle('showExpenseForm')"
        >
            <x-icons.busy target="print" />
            Expense Report
        </button>

        <div class="p-2">
            <p class="text-xs text-slate-500">Expense report between a specified date range by category</p>
        </div>
    </div>

    <x-modal x-data="{ show: $wire.entangle('showExpenseForm') }">
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
                <x-input.select wire:model.defer="category">
                    <option value="">Choose</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
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
