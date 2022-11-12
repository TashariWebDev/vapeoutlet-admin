<div>

    <div class="pb-5">
        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-400">Inventory</h3>
    </div>

    <div
        class="grid grid-cols-1 gap-y-4 py-3 px-2 rounded-lg shadow lg:grid-cols-4 lg:gap-x-3 bg-slate-100 dark:bg-slate-900">
        <div>
            <x-form.input.label for="search">
                Search
            </x-form.input.label>
            <x-form.input.text
                id="search"
                type="search"
                wire:model="searchQuery"
                autofocus
                placeholder="Search by company"
            />
        </div>
    </div>

    <div class="py-3">
        {{ $suppliers->links() }}
    </div>

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
