<div>

    <div class="p-2">
        <a
            class="link"
            href="{{ route('customers/show',$transaction->customer_id) }}"
        >Back to customer</a>
    </div>

    <div class="bg-slate-300 dark:bg-slate-900 p-6 rounded-lg">
        <form
            wire:submit.prevent="update"
            class="w-full lg:w-1/2"
        >
            <div class="py-3">
                <x-form.input.label
                    for="reference"
                >Transaction reference
                </x-form.input.label>
                <div>
                    <x-form.input.text
                        type="text"
                        id="reference"
                        wire:model.defer="transaction.reference"
                    />
                </div>
                @error('transaction.reference')
                <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-3">
                <x-form.input.label
                    for="date"
                >Transaction date
                </x-form.input.label>
                <div>
                    <x-form.input.text
                        type="date"
                        id="date"
                        wire:model.defer="transaction.date"
                    />
                    @if($transaction->date)
                        <div class="mt-2">
                            <p class="text-slate-500">{{ $transaction->date->format('Y-m-d') }}</p>
                        </div>
                    @else
                        <div class="mt-2">
                            <p class="text-slate-500">{{ $transaction->created_at->format('Y-m-d') }}</p>
                        </div>
                    @endif
                </div>
                @error('transaction.date')
                <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-3">
                <x-form.input.label
                    for="type"
                >Transaction type
                </x-form.input.label>
                <div>
                    <x-form.input.select
                        wire:model.defer="transaction.type"
                        id="type"
                        class="block w-full rounded-md bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-white border-slate-700 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                    >
                        <option value="">Choose</option>
                        <option
                            @selected( $transaction->type === 'debit')
                            value="debit"
                        >Debit
                        </option>
                        <option
                            @selected( $transaction->type === 'payment')
                            value="payment"
                        >Payment
                        </option>
                        <option
                            @selected( $transaction->type === 'refund')
                            value="refund"
                        >Refund
                        </option>
                    </x-form.input.select>
                </div>
                @error('transaction.type')
                <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-3">
                <x-form.input.label
                    for="amount"
                >Transaction amount
                </x-form.input.label>
                <div>
                    <x-form.input.text
                        type="number"
                        id="amount"
                        wire:model.defer="transaction.amount"
                        step="0.01"
                        inputmode="numeric"
                        pattern="[0-9.]+"
                    />
                </div>
                @error('transaction.amount')
                <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-3">
                <button class="button-success">
                    update
                </button>
            </div>

            <div class="mt-4"
                 wire:loading
                 wire:target="update"
            >
                <p class="text-green-500 text-xs">Processing! Please wait</p>
            </div>
        </form>

        <div class="py-3">
            <button
                class="text-red-600 text-xs hover:underline"
                wire:click="$toggle('confirmDelete')"
            >Delete
            </button>

            <x-modal
                wire:model.defer="confirmDelete"
            >

                <h2 class="font-bold">Are your sure?</h2>

                <div class="py-3 flex justify-start items-center space-x-3">
                    <button
                        class="button-danger"
                        wire:click="delete"
                    >Delete
                    </button>
                    <button
                        class="button-warning"
                        wire:click="$toggle('confirmDelete')"
                    >Never mind
                    </button>
                </div>

            </x-modal>
        </div>
    </div>
</div>
