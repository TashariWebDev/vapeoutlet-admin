<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('modal')"
    >
        add transaction
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New transaction</h3>
        </div>

        <div>
            <form wire:submit.prevent="save">
                <div class="py-3">
                    <x-input.label for="date">
                        date
                    </x-input.label>
                    <x-input.text
                        id="reference"
                        type="date"
                        wire:model.defer="date"
                    />
                    @error('date')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="reference">
                        reference
                    </x-input.label>
                    <x-input.text
                        id="reference"
                        type="text"
                        wire:model.defer="reference"
                    />
                    @error('reference')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="description">
                        description
                    </x-input.label>
                    <x-input.text
                        id="description"
                        type="text"
                        wire:model.defer="description"
                    />
                    @error('description')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="type">
                        type
                    </x-input.label>
                    <x-input.select
                        id="type"
                        wire:model.defer="type"
                    >
                        <option value="">Choose</option>
                        <option value="payment">Payment</option>
                        <option value="expense">Expense</option>
                    </x-input.select>
                    @error('type')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="amount">
                        Amount
                    </x-input.label>
                    <x-input.text
                        id="amount"
                        type="number"
                        wire:model.defer="amount"
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                    />
                    @error('amount')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <button class="button-success">
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
