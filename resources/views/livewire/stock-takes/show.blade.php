<div x-data="{}">

    <div class="flex justify-evenly items-center p-3 mb-2 w-full bg-white rounded-md">
        <div>
            <p class="font-bold">STOCK TAKE ID: {{ $stockTake->id }}</p>
        </div>
        <div>
            <p class="font-bold">DATE: {{ $stockTake->created_at }}</p>
        </div>
        <div>
            <p class="font-bold">CREATED BY: {{ $stockTake->created_by }}</p>
        </div>
        <div>
            <p class="font-bold">VARIANCE: {{ number_format(to_rands($stockTake->getTotal()), 2) }}</p>
        </div>
        <div>
            @if ($stockTake->processed_at)
                <p class="font-bold">PROCESSED BY {{ $stockTake->processed_by }} on {{ $stockTake->processed_at }}</p>
            @else
                <button
                    class="button-success"
                    x-on:click="$wire.set('showConfirmModal',true)"
                >PROCESS
                </button>
                <x-modal
                    title="Are your sure"
                    wire:model.defer="showConfirmModal"
                >
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
        <x-table.header class="hidden lg:grid lg:grid-cols-5">
            <x-table.heading>PRODUCT</x-table.heading>
            <x-table.heading class="text-right">SKU</x-table.heading>
            <x-table.heading class="text-right">COUNT</x-table.heading>
            <x-table.heading class="text-right">VARIANCE</x-table.heading>
            <x-table.heading class="text-right">VALUE</x-table.heading>
        </x-table.header>
        @foreach ($stockTake->items as $item)
            <x-table.body class="grid grid-cols-5">
                <x-table.row>
                    <p>{{ $item->product->brand }} {{ $item->product->name }} {{ $item->product->qty() }}</p>
                    <div class="flex space-x-2">
                        @foreach ($item->product->features as $feature)
                            <p class="text-xs whitespace-nowrap">{{ $feature->name }}</p>
                        @endforeach
                    </div>
                </x-table.row>
                <x-table.row class="text-right">
                    <p>{{ $item->product->sku }}</p>
                </x-table.row>
                <x-table.row class="text-right">
                    <label>
                        <input
                            class="py-1 w-full text-black rounded"
                            type="number"
                            value="{{ $item->count }}"
                            wire:change.debounce="updateItem({{ $item->id }},$event.target.value)"
                            @if ($stockTake->processed_at) readonly @endif
                        >
                    </label>
                </x-table.row>
                <x-table.row class="pl-4 text-right">
                    <p>{{ $item->variance }}</p>
                </x-table.row>
                <x-table.row class="pl-4 text-right">
                    <p>{{ number_format(to_rands($item->variance * $item->cost), 2) }}</p>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>
</div>
