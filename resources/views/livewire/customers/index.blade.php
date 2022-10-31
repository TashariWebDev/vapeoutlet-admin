<div>
    <div class="flex flex-wrap px-2 lg:justify-between items-center space-y-2 lg:space-y-0">
        <div class="w-full lg:w-auto">
            <x-inputs.search id="search"
                             wire:model="searchQuery"
                             label="Search"
            />
        </div>

        <div class="w-full lg:w-auto">
            <button class="button-success w-full"
                    x-on:click="@this.set('showCreateCustomerForm',true)"
            >
                <x-icons.plus class="w-5 w-5 mr-2"/>
                New customer
            </button>
        </div>
    </div>

    <x-slide-over title="Create customers"
                  wire:model.defer="showCreateCustomerForm"
    >
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="name"
                             label="name"
                             required
                    />
                </div>
                <div class="py-2">
                    <x-input type="email"
                             wire:model.defer="email"
                             label="email"
                             required
                    />
                </div>
                <div class="py-3">
                    <x-input type="text"
                             wire:model.defer="phone"
                             label="phone"
                    />
                </div>
                @hasPermissionTo('upgrade customers')
                <div class="py-2 bg-gray-100 rounded-md px-2">
                    <label for="is_wholesale"
                           class="text-xs uppercase font-medium flex items-center space-x-2"
                    >
                        <input type="checkbox"
                               wire:model.defer="is_wholesale"
                               id="is_wholesale"
                               class="rounded-full text-green-500 focus:ring-gray-200"
                        />
                        <span class="ml-3">Wholesale</span>
                    </label>
                </div>
                @endhasPermissionTo
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <div class="py-2">
        {{ $customers->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-5">
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Email</x-table.heading>
            <x-table.heading class="text-center">Phone</x-table.heading>
            <x-table.heading class="text-center">Wholesale</x-table.heading>
            <x-table.heading class="text-right">Balance</x-table.heading>
        </x-table.header>
        @forelse($customers as $customer)
            <x-table.body class="grid grid-cols-1 lg:grid-cols-5">
                <x-table.row class="text-center lg:text-left">
                    <a class="link"
                       href="{{ route('customers/show',$customer->id) }}"
                    >{{$customer->name}}</a>
                    <div class="pt-1">
                        <p class="text-xs text-gray-500">{{ $customer->salesperson->name ?? '' }}</p>
                    </div>
                </x-table.row>
                <x-table.row class="text-center lg:text-left text-sm font-semibold">{{ $customer->email }}</x-table.row>
                <x-table.row class="text-center text-sm">{{ $customer->phone }}</x-table.row>
                <x-table.row class="flex justify-center">
                    @if($customer->is_wholesale)
                        <x-icons.tick class="w-5 h-5 text-green-600"/>
                    @else
                        <x-icons.cross class="w-5 h-5 text-red-600"/>
                    @endif
                </x-table.row>
                <x-table.row class="text-center lg:text-right">
                    @if($customer->latestTransaction?->running_balance || $customer->latestTransaction?->running_balance > 0)
                        R {{ number_format($customer->latestTransaction?->running_balance,2)}}
                    @else
                        0.00
                    @endif
                </x-table.row>
            </x-table.body>
        @empty
        @endforelse
    </x-table.container>
</div>
