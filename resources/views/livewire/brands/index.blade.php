<div>

    <div class="py-3 px-2 bg-white rounded-lg shadow dark:bg-slate-800">

        <x-page-header class="px-2">
            Brands
        </x-page-header>

        <div class="py-3 px-2 w-64">
            <x-input.label for="search">
                Search
            </x-input.label>
            <x-input.text
                id="search"
                type="text"
                placeholder="name"
                wire:model="searchQuery"
                autofocus
                autocomplete="off"
            ></x-input.text>
            <x-input.helper>
                Query Time {{ round($queryTime, 3) }} ms
            </x-input.helper>
        </div>

        <div class="py-3 px-2">
            {{ $brands->links() }}
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading>Image</x-table.heading>
                <x-table.heading>Upload image</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading class="text-right">Actions</x-table.heading>
            </x-table.header>
            @forelse ($brands as $brand)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row>
                        <img
                            class="w-20 h-20 bg-white rounded-sm"
                            src="{{ $brand->image }}"
                            alt=""
                        >
                    </x-table.row>
                    <x-table.row>
                        <x-input.text
                            class="z-10"
                            type="file"
                            wire:model="image"
                            x-on:livewire-upload-finish="$wire.call('updateImage',{{ $brand->id }})"
                        />
                        <div class="absolute z-0 px-3 w-full text-xs">
                            <p>&uparrow; upload new image</p>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                type="text"
                                value="{{ $brand->name }}"
                                x-on:keydown.tab="$wire.call('updateBrand','{{ $brand->id }}',$event.target.value)"
                            />
                        </label>
                    </x-table.row>
                    <x-table.row class="text-right">
                        @if (!$brand->products_count)
                            <button
                                class="w-full lg:w-32 button-danger"
                                wire:click="delete('{{ $brand->id }}')"
                            >
                                delete
                            </button>
                        @else
                            <p>{{ $brand->products_count }} linked to this brand</p>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
