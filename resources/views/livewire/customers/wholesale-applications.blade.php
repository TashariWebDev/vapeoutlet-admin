<div>
    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-900">
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
                <x-table.header class="hidden lg:grid lg:grid-cols-4">
                    <x-table.heading>Name</x-table.heading>
                    <x-table.heading>Email</x-table.heading>
                    <x-table.heading class="text-center">Phone</x-table.heading>
                    <x-table.heading class="text-center">Company</x-table.heading>
                </x-table.header>
                @forelse($customers as $customer)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row class="text-center lg:text-left">
                            <a
                                class="link"
                                href="{{ route('customers/wholesale/approval', $customer->id) }}"
                            >{{ $customer->name }}</a>
                        </x-table.row>
                        <x-table.row
                            class="text-xs font-semibold text-center lg:text-left text-slate-500"
                        >{{ strtolower($customer->email) }}</x-table.row>
                        <x-table.row class="text-xs text-center text-slate-500">
                            <p>{{ $customer->phone }}</p>
                            <p>{{ $customer->alt_phone }}</p>
                        </x-table.row>
                        <x-table.row class="text-center">
                            <p>{{ $customer->company }}</p>
                            <p>{{ $customer->registered_company_name }}</p>
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
                <div class="grid grid-cols-3 py-3 px-2 text-xs bg-white rounded dark:bg-slate-950">
                    <div>
                        <a
                            class="link"
                            href="{{ route('customers/wholesale/approval', $customer->id) }}"
                        >{{ $customer->name }}</a>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 dark:text-slate-300">{{ $customer->phone }}</p>
                    </div>
                    <div class="text-right">

                    </div>
                </div>
            @empty
                <x-table.empty />
            @endforelse
        </div>
    </div>
</div>
