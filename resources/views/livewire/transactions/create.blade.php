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
                    <x-form.input.label for="reference">
                        Reference
                    </x-form.input.label>

                    <div>
                        <x-form.input.text
                            id="reference"
                            type="text"
                            wire:model.defer="reference"
                        />
                    </div>
                    @error('reference')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="date">
                        Date
                    </x-form.input.label>
                    <div>
                        <x-form.input.text
                            id="date"
                            type="date"
                            wire:model.defer="date"
                        />
                    </div>
                    @error('date')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="type">
                        Type
                    </x-form.input.label>
                    <div>
                        <x-form.input.select
                            id="type"
                            wire:model.defer="type"
                        >
                            <option value="">Choose</option>
                            <option value="debit">Debit</option>
                            <option value="payment">Payment</option>
                            <option value="refund">Refund</option>
                            <option value="warranty">Warranty</option>
                        </x-form.input.select>
                    </div>
                    @error('type')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="amount">
                        Amount
                    </x-form.input.label>
                    <div>
                        <x-form.input.text
                            id="amount"
                            type="number"
                            wire:model.defer="amount"
                            step="0.01"
                            inputmode="numeric"
                            pattern="[0-9.]+"
                        />
                    </div>
                    @error('amount')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
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
