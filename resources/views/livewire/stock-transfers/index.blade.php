<div>
    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-4 lg:gap-x-3">
            <div>
                <x-input.label for="search">
                    Search
                </x-input.label>
                <x-input.text
                    id="search"
                    type="search"
                    wire:model="searchQuery"
                    autocomplete="off"
                    autofocus
                    placeholder="Search name"
                />
                <x-input.helper>
                    Query Time {{ round($queryTime, 3) }} ms
                </x-input.helper>
            </div>
            <div></div>
            <div>
                <x-input.label>
                    No of records
                </x-input.label>
                <x-input.select wire:model="recordCount">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-input.select>
            </div>
            <div class="flex justify-end">
                <livewire:stock-transfers.create />
            </div>
        </div>

        <div class="py-2 px-2">
            {{ $transfers->links() }}
        </div>

        {{-- desktop --}}
        <div class="hidden lg:block">
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-4">
                    <x-table.heading>ID</x-table.heading>
                    <x-table.heading>From/To</x-table.heading>
                    <x-table.heading>Status</x-table.heading>
                    <x-table.heading class="lg:text-right">Print</x-table.heading>
                </x-table.header>
                @forelse($transfers as $transfer)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row>
                            <a
                                class="link"
                                href="{{ route('stock-transfers/edit', $transfer->id) }}"
                            >
                                {{ $transfer->number() }}
                            </a>
                            <p>{{ $transfer->date->format('d-m-y H:i') }}</p>
                        </x-table.row>
                        <x-table.row>
                            <p class="capitalize">
                                Stock transfer from
                                <span class="text-blue-600 dark:text-blue-400">{{ $transfer->dispatcher->name }}</span>
                                to
                                <span
                                    class="text-yellow-600 dark:text-yellow-300"
                                >{{ $transfer->receiver->name }}</span>
                            </p>
                            <p>{{ $transfer->getTotal() }}</p>
                        </x-table.row>
                        <x-table.row>
                            @if (!$transfer->isProcessed())
                                <div
                                    class="py-1 px-3 text-xs text-center text-rose-800 uppercase bg-rose-300 rounded-r-full rounded-l-full"
                                >
                                    <p>Pending</p>
                                </div>
                            @else
                                <div
                                    class="py-1 px-3 text-xs text-center text-indigo-800 uppercase bg-indigo-300 rounded-r-full rounded-l-full"
                                >
                                    <p>Processed</p>
                                </div>
                            @endif
                            <p class="py-1 text-center capitalize">
                                {{ $transfer->user->name }}
                            </p>
                        </x-table.row>
                        <x-table.row class="lg:text-right">
                            <div>
                                <button
                                    class="button button-success"
                                    wire:loading.attr="disabled"
                                    wire:target="print"
                                    wire:click="print({{ $transfer->id }})"
                                >
                                    <span
                                        class="pr-2"
                                        wire:loading
                                        wire:target="print({{ $transfer->id }})"
                                    >
                                        <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                                    </span>
                                    Print
                                </button>
                            </div>
                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty />
                @endforelse
            </x-table.container>
        </div>

    </div>
</div>
