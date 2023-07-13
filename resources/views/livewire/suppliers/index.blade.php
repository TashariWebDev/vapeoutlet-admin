<div>

    <x-page-header class="pb-3">
        Suppliers
    </x-page-header>

    <div class="px-2 bg-white rounded-md shadow-sm dark:bg-slate-900">
        <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-2 lg:gap-x-3">
            <div>
                <div class="w-full lg:w-64">
                    <x-input.label for="search">
                        Search
                    </x-input.label>
                    <x-input.text
                        id="search"
                        type="search"
                        wire:model="searchQuery"
                        autocomplete="off"
                        autofocus
                        placeholder="Search by company"
                    />
                </div>
            </div>

            <div class="flex justify-end items-center space-x-2">

                <livewire:purchases.create />
                <livewire:suppliers.create :fullButton="true" />
            </div>
        </div>

        <div class="py-3 px-2">
            {{ $suppliers->links() }}
        </div>
    </div>

    <div class="mt-4 bg-white rounded-md shadow-sm dark:bg-slate-900">
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-6">
                <x-table.heading>id</x-table.heading>
                <x-table.heading class="col-span-2">name</x-table.heading>
                <x-table.heading>email</x-table.heading>
                <x-table.heading>phone</x-table.heading>
                <x-table.heading>contact</x-table.heading>
            </x-table.header>
            @forelse($suppliers as $supplier)
                <x-table.body class="grid grid-cols-1 text-sm lg:grid-cols-6">
                    <x-table.row class="text-center lg:text-left">{{ $supplier->id }}</x-table.row>
                    <x-table.row class="text-center lg:col-span-2 lg:text-left">
                        <a
                            class="link"
                            href="{{ route('suppliers/show', $supplier->id) }}"
                        >
                            {{ $supplier->name }}
                        </a>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-left">{{ $supplier->email }}</x-table.row>
                    <x-table.row class="text-center lg:text-left">{{ $supplier->phone }}</x-table.row>
                    <x-table.row class="text-center lg:text-left">{{ $supplier->person }}</x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>

</div>
