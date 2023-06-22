<div>
    <div class="px-2 bg-white rounded-lg dark:bg-slate-900">
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
                    placeholder="Search by name, email, phone, company"
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
            </div>
        </div>

        <div class="px-2">
            <x-input.helper>
                Query Time {{ round($queryTime, 3) }} ms
            </x-input.helper>
        </div>

        <div class="py-2 px-2">
            {{ $customers->links() }}
        </div>
    </div>

    {{-- desktop --}}
    <div class="hidden mt-2 bg-white rounded-lg lg:block dark:bg-slate-900">
        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Email</x-table.heading>
                <x-table.heading class="text-center">Phone</x-table.heading>
                <x-table.heading class="text-center">Type</x-table.heading>
            </x-table.header>
            @forelse($customers as $customer)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        <a
                            class="link"
                            href="{{ route('customers/show', $customer->id) }}"
                        ><span class="pr-1 text-[10px]">({{$customer->id}})</span> {{ $customer->name }}</a>
                        <div class="pt-1">
                            <p class="font-semibold text-[12px]">
                                {{ $customer->salesperson->name ?? '' }}</p>
                        </div>
                    </x-table.row>
                    <x-table.row
                        class="font-semibold text-[12px]"
                    >{{ strtolower($customer->email) }}</x-table.row>
                    <x-table.row
                        class="text-center"
                    ><p class="font-semibold uppercase text-[12px]">{{ $customer->phone }}</p></x-table.row>
                    <x-table.row class="flex justify-center">
                        @if ($customer->is_wholesale)
                            <p class="font-semibold text-rose-600 uppercase dark:text-rose-400 text-[12px]">
                                Wholesale
                            </p>
                        @else
                            <p class="font-semibold uppercase text-sky-600 text-[12px] dark:text-sky-400">
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
    <div class="grid grid-cols-1 gap-y-2 px-1 mt-2 lg:hidden">
        @forelse($customers as $customer)
            <div class="grid grid-cols-1 py-3 px-2 text-xs bg-white rounded dark:bg-slate-900">
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
