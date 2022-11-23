<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('modal')"
    ><span class="pl-2">Transaction</span>
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New transaction</h3>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $this->customer->name }}</p>
        </div>

        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-input.label for="reference">
                        Reference
                    </x-input.label>

                    <div>
                        <x-input.text
                            id="reference"
                            type="text"
                            wire:model.defer="reference"
                        />
                    </div>
                    @error('reference')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="date">
                        Date
                    </x-input.label>
                    <div>
                        <x-input.text
                            id="date"
                            type="date"
                            wire:model.defer="date"
                        />
                    </div>
                    @error('date')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="type">
                        Type
                    </x-input.label>
                    <div>
                        <x-input.select
                            id="type"
                            wire:model.defer="type"
                        >
                            <option value="">Choose</option>
                            <option value="debit">Debit</option>
                            <option value="payment">Payment</option>
                            <option value="refund">Refund</option>
                            <option value="warranty">Warranty</option>
                        </x-input.select>
                    </div>
                    @error('type')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="amount">
                        Amount
                    </x-input.label>
                    <div>
                        <x-input.text
                            id="amount"
                            type="number"
                            wire:model.defer="amount"
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                        />
                    </div>
                    @error('amount')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
