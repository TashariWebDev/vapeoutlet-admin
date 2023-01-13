<div>

    <x-modal x-data="{ show: $wire.entangle('showStockTakeModal') }">
        <div class="py-3">
            <p class="text-slate-800 dark:text-slate-500">Ensure you are on the correct sales channel!</p>
        </div>
        <form wire:submit.prevent="createStockTake">
            <div class="overflow-y-scroll p-3 h-72 border shadow-inner border-slate-800">
                @foreach ($this->brands as $brand)
                    <div
                        class="p-1 mb-1 w-full text-xs rounded dark:text-white bg-slate-100 text-slate-800 dark:bg-sky-700">
                        <label>
                            <input
                                type="checkbox"
                                value="{{ $brand->name }}"
                                wire:model.defer="selectedBrands"
                            >
                        </label>{{ $brand->name }}
                    </div>
                @endforeach
            </div>
            <div class="mt-2">
                <button class="button-success">Create</button>
            </div>
        </form>
    </x-modal>

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="py-3">
            <div class="flex justify-between w-full">
                <div>
                    <x-input.label>
                        Search
                    </x-input.label>
                    <x-input.text
                        type="search"
                        placeholder="search"
                        autofocus
                        wire:model="searchQuery"
                    />
                </div>

                <div>
                    <button
                        class="button-success"
                        x-on:click="@this.set('showStockTakeModal',true)"
                    >Create stock take
                    </button>
                </div>

            </div>
            <div class="py-6">
                {{ $stockTakes->links() }}
            </div>
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-6">
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>DATE</x-table.heading>
                <x-table.heading>BRAND</x-table.heading>
                <x-table.heading>CREATED BY</x-table.heading>
                <x-table.heading>COUNT SHEET</x-table.heading>
                <x-table.heading class="text-center">print</x-table.heading>
            </x-table.header>
            @forelse($stockTakes as $stockTake)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
                    <x-table.row>
                        <a
                            class="link"
                            href="{{ route('stock-takes/show', $stockTake->id) }}"
                        >{{ $stockTake->id }}</a>
                    </x-table.row>
                    <x-table.row>
                        <p>{{ $stockTake->created_at }}</p>
                    </x-table.row>
                    <x-table.row>
                        <p class="uppercase">{{ $stockTake->brand }}</p>
                        <p class="font-bold">{{ $stockTake->sales_channel->name }}</p>
                    </x-table.row>
                    <x-table.row>
                        <p>{{ $stockTake->created_by }}</p>
                    </x-table.row>
                    <x-table.row>
                        @if ($stockTake->processed_at)
                            <div>
                                <p>PROCESSED</p>
                            </div>
                        @else
                            <button
                                class="button button-success"
                                wire:loading.attr="disabled"
                                wire:target="getDocument"
                                wire:click="getDocument({{ $stockTake->id }})"
                            >
                                <span
                                    class="pr-2"
                                    wire:loading
                                    wire:target="getDocument({{ $stockTake->id }})"
                                >
                                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                </span>
                                Print
                            </button>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center">
                        @if ($stockTake->processed_at)
                            <div>
                                <p>PROCESSED</p>
                            </div>
                        @else
                            <div class="flex items-center space-x-2">
                                <button
                                    class="button button-success"
                                    wire:loading.attr="disabled"
                                    wire:target="getDocument"
                                    wire:click="getStockTakeDocument({{ $stockTake->id }})"
                                >
                                    <span
                                        class="pr-2"
                                        wire:loading
                                        wire:target="getStockTakeDocument({{ $stockTake->id }})"
                                    >
                                        <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                    </span>
                                    Print
                                </button>

                                <button
                                    class="button-danger"
                                    wire:click="delete('{{ $stockTake->id }}')"
                                >Delete
                                </button>
                            </div>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
