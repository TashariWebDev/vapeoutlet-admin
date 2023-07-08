<div>
    <div class="px-4 bg-white rounded-md shadow-sm dark:bg-slate-900">
        <div class="grid grid-cols-1 gap-y-4 py-3 lg:grid-cols-4 lg:gap-x-3">
            <div>
                <x-input.text
                    id="search"
                    type="search"
                    wire:model="searchQuery"
                    autocomplete="off"
                    autofocus
                    placeholder="Search"
                />
            </div>
            <div class="hidden lg:block"></div>
            <div class="hidden lg:block"></div>
            <div class="flex items-end space-x-2">
                @hasPermissionTo('view reports')
                <div>
                    <button
                        class="button-alt"
                        wire:click="export"
                        wire:loading.attr="disabled"
                    >Excel
                    </button>
                </div>
                @endhasPermissionTo
                <div class="w-full">
                    <x-input.select wire:model="recordCount">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-input.select>
                </div>
            </div>
        </div>


        <div class="py-2 mt-4">
            {{ $customers->links() }}
        </div>
    </div>

    {{-- desktop --}}
    <div class="hidden mt-4 bg-white rounded-md shadow lg:block dark:bg-slate-900">
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Email</x-table.heading>
                <x-table.heading>Phone</x-table.heading>
                <x-table.heading>Type</x-table.heading>
            </x-table.header>
            @forelse($customers as $customer)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        <div class="flex space-x-1">
                            <p class="pr-1 text-xs dark:text-white text-slate-900">{{$customer->id}}</p>
                            <a
                                class="link"
                                href="{{ route('customers/show', $customer->id) }}"
                            >{{ $customer->name }}</a>
                        </div>
                        <div>
                            <p class="text-xs font-semibold">
                                {{ $customer->salesperson->name ?? '' }}</p>
                        </div>
                    </x-table.row>
                    <x-table.row
                        class="text-sm font-semibold"
                    >{{ strtolower($customer->email) }}</x-table.row>
                    <x-table.row>
                        <p class="text-sm font-semibold uppercase">{{ $customer->phone }}</p>
                    </x-table.row>
                    <x-table.row>
                        @if ($customer->is_wholesale)
                            <p class="text-sm font-semibold text-rose-600 uppercase dark:text-rose-400">
                                Wholesale
                            </p>
                        @else
                            <p class="text-sm font-semibold uppercase text-sky-600 dark:text-sky-400">
                                Retail
                            </p>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty />
            @endforelse
        </x-table.container>
    </div>

    {{-- Mobile --}}
    <div class="grid grid-cols-1 gap-y-2 mt-2 lg:hidden">
        @forelse($customers as $customer)
            <div class="grid grid-cols-1 py-3 px-2 text-xs bg-white rounded-md shadow-sm dark:bg-slate-900">
                <div>
                    <a
                        class="link"
                        href="{{ route('customers/show', $customer->id) }}"
                    >{{ $customer->name }}</a>
                    <div class="pt-1">
                        <p class="text-xs text-slate-600 dark:text-slate-300">
                            {{ $customer->salesperson->name ?? '' }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-slate-600 dark:text-slate-300">{{ $customer->phone }}</p>
                    @if ($customer->is_wholesale)
                        <p class="text-xs text-rose-600 dark:text-rose-400">Wholesale</p>
                    @else
                        <p class="text-xs text-sky-600 dark:text-sky-400">Retail</p>
                    @endif
                </div>
            </div>
        @empty
            <x-table.empty />
        @endforelse
    </div>
</div>
