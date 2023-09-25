<div>

    <x-page-header>
        Edit Supplier transaction
    </x-page-header>
    <div class="pb-2">
        <a
            class="link"
            href="{{ route('suppliers/show', $transaction->supplier_id) }}"
        >Back to {{ $transaction->supplier->name }}</a>
    </div>

    <div class="p-4 w-full bg-white rounded-md shadow-sm lg:w-1/2 dark:bg-slate-900">
        <form
            class=""
            wire:submit.prevent="update"
        >
            <div class="py-3">
                <x-input.label for="reference">Transaction reference
                </x-input.label>
                <div>
                    <x-input.text
                        id="reference"
                        type="text"
                        wire:model.defer="transaction.reference"
                    />
                </div>
                @error('transaction.reference')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-3">
                <x-input.label for="description">Transaction description
                </x-input.label>
                <div>
                    <x-input.text
                        id="description"
                        type="text"
                        wire:model.defer="transaction.description"
                    />
                </div>
                @error('transaction.description')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>


            <div class="py-3">
                <x-input.label for="date">Transaction date
                </x-input.label>
                <div>
                    <div>
                        <x-input.text
                            id="date"
                            type="date"
                            wire:model.defer="transaction.date"
                            required
                        />
                    </div>
                    @if ($transaction->date)
                        <div class="mt-2">
                            <p class="text-xs text-slate-600 dark:text-slate-300">
                                {{ $transaction->date->format('d-m-y') }}
                            </p>
                        </div>
                    @else
                        <div class="mt-2">
                            <p class="text-xs text-slate-600 dark:text-slate-300">
                                {{ $transaction->created_at->format('d-m-y') }}
                            </p>
                        </div>
                    @endif
                </div>
                @error('transaction.date')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-3">
                <x-input.label for="type">Transaction type
                </x-input.label>
                <div>
                    <x-input.select
                        id="type"
                        wire:model.defer="transaction.type"
                    >
                        <option value="">Choose</option>
                        <option
                            value="expense"
                            @selected($transaction->type === 'expense')
                        >Expense
                        </option>
                        <option
                            value="payment"
                            @selected($transaction->type === 'payment')
                        >Payment
                        </option>
                    </x-input.select>
                </div>
                @error('transaction.type')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-3">
                <x-input.label for="amount">Transaction amount
                </x-input.label>
                <div>
                    <x-input.text
                        id="amount"
                        type="number"
                        wire:model.defer="transaction.amount"
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                    />
                </div>
                @error('transaction.amount')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-3">
                <button class="button-success">
                    update
                </button>
            </div>

            <div
                class="mt-4"
                wire:loading
                wire:target="update"
            >
                <p class="text-xs text-sky-500">Processing! Please wait</p>
            </div>
        </form>

        <div class="flex justify-end py-3 px-3 w-full rounded-md bg-slate-100 dark:bg-slate-700">
            <button
                class="link-alt"
                wire:click="$toggle('confirmDelete')"
            >Delete
            </button>

            <x-modal x-data="{ show: $wire.entangle('confirmDelete') }">

                <x-page-header>
                    Are your sure?
                </x-page-header>

                <div class="flex justify-start items-center py-3 space-x-3">
                    <button
                        class="button-success"
                        wire:click="delete"
                    >Delete
                    </button>
                    <button
                        class="button-alt"
                        wire:click="$toggle('confirmDelete')"
                    >Never mind
                    </button>
                </div>

            </x-modal>
        </div>
    </div>
</div>
