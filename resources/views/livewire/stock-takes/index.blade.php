<div>

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="py-3">
            <div class="w-full lg:w-64">
                <x-form.input.label>
                    Search
                </x-form.input.label>
                <x-form.input.text
                    type="search"
                    placeholder="search"
                    autofocus
                    wire:model="searchQuery"
                />
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
