<div>

    <x-modal
        x-data="{ show: $wire.entangle('modal') }"
        x-cloak
    >
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New order</h3>
        </div>

        <div class="w-full h-72">
            <div>
                <label
                    class="text-xs text-slate-400"
                    for="search"
                >
                    Customer search
                </label>
                <div>
                    <x-form.input.text
                        id="search"
                        type="text"
                        autofocus
                        autocomplete="off"
                        wire:model="searchQuery"
                    />
                </div>
            </div>

            @if ($searchQuery)
                <div class="overflow-y-scroll mt-1 w-full h-48">
                    <ul>
                        @foreach ($this->customers as $customer)
                            <li>
                                <button
                                    class="mb-1 w-full text-left whitespace-nowrap button-success"
                                    wire:click="createOrder({{ $customer->id }})"
                                >{{ $customer->name }} {{ $customer?->company }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </x-modal>

</div>
