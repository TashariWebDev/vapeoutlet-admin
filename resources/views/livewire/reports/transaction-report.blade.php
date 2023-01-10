<div>
    <div>
        <div>
            <button
                class="w-full button-success"
                wire:click="$toggle('showTransactionForm')"
            >
                Transaction Report
            </button>

            <div class="p-2">
                <p class="text-xs text-slate-500">Transactions between a specified date by type</p>
            </div>
        </div>

        <x-modal x-data="{ show: $wire.entangle('showTransactionForm') }">
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
                    <x-input.select wire:model.defer="type">
                        <option value="">Choose</option>
                        <option value="debit">Debits</option>
                        <option value="payment">Payments</option>
                        <option value="refund">Refunds</option>
                        <option value="warranty">Warranty</option>
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

</div>
