<div>
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-2 md:px-0">
        <div class="md:col-span-2">
            <x-inputs.search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full">
        </div>
        <div></div>
        <div></div>
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
            <x-table.body class="grid grid-cols-1 lg:grid-cols-6 text-sm">
                <x-table.row class="text-center lg:text-left">{{ $supplier->id }}</x-table.row>
                <x-table.row class="lg:col-span-2 text-center lg:text-left">
                    <a href="{{ route('suppliers/show',$supplier->id) }}" class="link">
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
