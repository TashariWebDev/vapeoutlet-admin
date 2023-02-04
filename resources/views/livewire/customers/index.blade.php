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
                    placeholder="Search by name, email, phone, company"
                />
                <x-input.helper>
                    Query Time {{ round($queryTime, 3) }} ms
                </x-input.helper>
            </div>
            <div></div>
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
        </div>

        <div class="py-2 px-2">
            {{ $customers->links() }}
        </div>

        {{-- desktop --}}
        <div class="hidden lg:block">
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-5">
                    <x-table.heading>Name</x-table.heading>
                    <x-table.heading>Email</x-table.heading>
                    <x-table.heading class="text-center">Phone</x-table.heading>
                    <x-table.heading class="text-center">Type</x-table.heading>
                    <x-table.heading class="text-right">Balance</x-table.heading>
                </x-table.header>
                @forelse($customers as $customer)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-5">
                        <x-table.row class="text-center lg:text-left">
                            <a
                                class="link"
                                href="{{ route('customers/show', $customer->id) }}"
                            >{{ $customer->name }}</a>
                            <div class="pt-1">
                                <p class="text-xs text-slate-600 dark:text-slate-300">
                                    {{ $customer->salesperson->name ?? '' }}</p>
                            </div>
                        </x-table.row>
                        <x-table.row
                            class="text-xs font-semibold text-center lg:text-left text-slate-500">{{ $customer->email }}</x-table.row>
                        <x-table.row class="text-xs text-center text-slate-500">{{ $customer->phone }}</x-table.row>
                        <x-table.row class="flex justify-center">
                            @if ($customer->is_wholesale)
                                <p class="text-rose-600 dark:text-rose-400">Wholesale</p>
                            @else
                                <p class="text-blue-600 dark:text-blue-400">Retail</p>
                            @endif
                        </x-table.row>
                        <x-table.row class="text-center lg:text-right text-slate-600 dark:text-slate-300">
                            R {{ number_format($customer->latestTransaction?->running_balance, 2) ?? 0.0 }}
                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty />
                @endforelse
            </x-table.container>
        </div>

        {{-- Mobile --}}
        <div class="grid grid-cols-1 gap-y-2 px-1 lg:hidden">
            @forelse($customers as $customer)
                <div class="grid grid-cols-3 py-3 px-2 text-xs bg-white rounded dark:bg-slate-900">
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
                            <p class="text-xs text-blue-600 dark:text-blue-400">Retail</p>
                        @endif
                    </div>
                    <div class="text-right">
                        @if ($customer->latestTransaction?->running_balance || $customer->latestTransaction?->running_balance > 0)
                            <p class="text-xs text-slate-600 dark:text-slate-300">
                                R {{ number_format($customer->latestTransaction?->running_balance, 2) }}</p>
                        @else
                            <p class="text-xs text-slate-600 dark:text-slate-300">0.00</p>
                        @endif
                    </div>
                </div>
            @empty
                <x-table.empty />
            @endforelse
        </div>
    </div>
</div>
