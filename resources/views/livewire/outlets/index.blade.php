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
                <livewire:outlets.create />
            </div>
        </div>

        <div class="py-2 px-2">
            {{ $outlets->links() }}
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
                @forelse($outlets as $outlet)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row>
                            <p>{{ $outlet->id }}</p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <div class="pt-1">
                                <p class="capitalize">
                                    {{ $outlet->name }}
                                </p>
                            </div>
                        </x-table.row>
                        <x-table.row>
                            <div class="pt-1">
                                @if (!$outlet->isLocked())
                                    @if ($outlet->allowsShipping())
                                        <button
                                            class="button-danger"
                                            wire:click="disableShipping({{ $outlet->id }})"
                                        >Disable shipping
                                        </button>
                                    @else
                                        <button
                                            class="button-success"
                                            wire:click="enableShipping({{ $outlet->id }})"
                                        >Enable shipping
                                        </button>
                                    @endif
                                @else
                                    <p>locked</p>
                                @endif
                            </div>
                        </x-table.row>
                        <x-table.row>
                            @if (!$outlet->isLocked())
                                <button
                                    class="button-danger"
                                    wire:click="deleteOutlet({{ $outlet->id }})"
                                >Delete outlet
                                </button>
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
