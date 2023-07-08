<div>
    <div class="px-2 bg-white rounded-md shadow-sm dark:bg-slate-900">
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
                <livewire:sales-channels.create />
            </div>
        </div>

        <div class="py-2 px-2">
            {{ $channels->links() }}
        </div>

        {{-- desktop --}}
        <div class="hidden lg:block">
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-4">
                    <x-table.heading>ID</x-table.heading>
                    <x-table.heading>Name</x-table.heading>
                    <x-table.heading>Allows Shipping</x-table.heading>
                    <x-table.heading>Actions</x-table.heading>
                </x-table.header>
                @forelse($channels as $channel)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row>
                            <p>{{ $channel->id }}</p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <div class="pt-1">
                                <p class="capitalize">
                                    {{ $channel->name }}
                                </p>
                            </div>
                        </x-table.row>
                        <x-table.row>
                            <div class="pt-1">
                                @if (!$channel->isLocked())
                                    @if ($channel->allowsShipping())
                                        <button
                                            class="button-danger"
                                            wire:click="disableShipping({{ $channel->id }})"
                                        >Disable shipping
                                        </button>
                                    @else
                                        <button
                                            class="button-success"
                                            wire:click="enableShipping({{ $channel->id }})"
                                        >Enable shipping
                                        </button>
                                    @endif
                                @else
                                    <p>locked</p>
                                @endif
                            </div>
                        </x-table.row>
                        <x-table.row>
                            @if (!$channel->isLocked())
                                @if ($channel->stocks_sum_qty < 1)
                                    @if ($channel->trashed())
                                        <button
                                            class="button-success"
                                            wire:click="enableChannel({{ $channel->id }})"
                                        >Enable sales channel
                                        </button>
                                    @else
                                        <button
                                            class="button-danger"
                                            wire:click="disableChannel({{ $channel->id }})"
                                        >Disable sales channel
                                        </button>
                                    @endif
                                @else
                                    {{ $channel->stocks_sum_qty }} items in stock
                                @endif
                            @else
                                <p>locked</p>
                            @endif

                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty />
                @endforelse
            </x-table.container>
        </div>

    </div>
</div>
