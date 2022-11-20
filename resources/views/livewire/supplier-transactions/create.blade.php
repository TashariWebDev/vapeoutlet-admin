<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('modal')"
    >
        add transaction
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New transaction</h3>
        </div>

        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-form.input.label for="reference">
                        reference
                    </x-form.input.label>
                    <x-form.input.text
                        id="reference"
                        type="text"
                        wire:model.defer="reference"
                    />
                    @error('reference')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="type">
                        type
                    </x-form.input.label>
                    <x-form.input.select
                        id="type"
                        wire:model.defer="type"
                    >
                        <option value="">Choose</option>
                        <option value="payment">Payment</option>
                        <option value="expense">Expense</option>
                    </x-form.input.select>
                    @error('type')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="amount">
                        type
                    </x-form.input.label>
                    <x-form.input.text
                        id="amount"
                        type="number"
                        wire:model.defer="amount"
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                    />
                    @error('amount')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="mr-3 w-5 h-5" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
