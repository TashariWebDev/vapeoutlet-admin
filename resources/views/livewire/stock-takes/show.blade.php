<div x-data="{}">

    <div class="bg-white rounded-md dark:bg-gray-800 text-slate-400 dark:text-slate-500">
        <div class="grid grid-cols-1 p-3 mb-2 w-full lg:grid-cols-4">
            <div>
                <p class="text-xs font-bold">{{ $stockTake->number }}</p>
            </div>
            <div>
                <p class="text-xs font-bold">{{ $stockTake->created_at->format('d-m-y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs font-bold">CREATED BY: {{ $stockTake->created_by }}</p>
            </div>
            <div>
                @if ($stockTake->processed_at)
                    <p class="text-xs font-bold uppercase">PROCESSED BY {{ $stockTake->processed_by }}
                        on {{ $stockTake->processed_at }}</p>
                @else
                    <button
                        class="button-success"
                        x-on:click="$wire.set('showConfirmModal',true)"
                    >PROCESS
                    </button>
                    <x-modal x-data="{ show: $wire.entangle('showConfirmModal') }">
                        <x-page-header>
                            Are you sure?
                        </x-page-header>
                        <div class="flex items-center space-x-3">
                            <button
                                class="button-success"
                                x-on:click="$wire.call('process')"
                            >
                                CONFIRM
                            </button>
                            <button
                                class="button-danger"
                                x-on:click="$wire.set('showConfirmModal',false)"
                            >
                                CANCEL
                            </button>
                        </div>
                    </x-modal>
                @endif
            </div>
        </div>
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading class="col-span-2">PRODUCT</x-table.heading>
                <x-table.heading class="text-right">COUNT</x-table.heading>
                <x-table.heading class="text-right">VARIANCE</x-table.heading>
            </x-table.header>
            @foreach ($stockTake->items as $item)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="col-span-2">
                        <x-product-listing-simple :product="$item->product"></x-product-listing-simple>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <label></label>
                        @if ($stockTake->processed_at)
                            <x-form.input.text
                                type="text"
                                value="{{ $item->count }}"
                                disabled
                                wire:change.debounce="updateItem({{ $item->id }},$event.target.value)"
                            />
                        @else
                            <x-form.input.text
                                type="number"
                                value="{{ $item->count }}"
                                wire:change.debounce="updateItem({{ $item->id }},$event.target.value)"
                                pattern="[0-9]*"
                                inputmode="numeric"
                                step="0.01"
                            />
                        @endif
                    </x-table.row>
                    <x-table.row class="pl-4 text-right">
                        <p>{{ $item->variance }}</p>
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>

</div>
