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
                    Query Time {{ round($queryTime, 3) }} s
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
                    <x-table.heading>From</x-table.heading>
                    <x-table.heading>To</x-table.heading>
                    <x-table.heading>Status</x-table.heading>
                </x-table.header>
                @forelse($transfers as $transfer)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row>
                            <p>{{ $transfer->number() }}</p>
                            <p>{{ $transfer->date->format('d-m-y H:i') }}</p>
                        </x-table.row>
                        <x-table.row>
                            <p class="capitalize">
                                {{ $transfer->dispatcher->name }}
                            </p>
                        </x-table.row>
                        <x-table.row>
                            <p class="capitalize">
                                {{ $transfer->receiver->name }}
                            </p>
                        </x-table.row>
                        <x-table.row>
                            @if (!$transfer->isProcessed())
                                <div class="py-1 px-3 text-red-800 uppercase bg-red-300">
                                    <p>Pending</p>
                                </div>
                            @else
                                <div class="py-1 px-3 text-green-800 uppercase bg-green-300">
                                    <p>Processed</p>
                                </div>
                            @endif
                            <p class="capitalize">
                                {{ $transfer->user->name }}
                            </p>
                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty />
                @endforelse
            </x-table.container>
        </div>

    </div>
</div>
