<div class="rounded-md px-2 py-6">

    <div class="w-full text-center flex justify-center">
        <x-inputs.search wire:model="searchTerm"/>
    </div>


    <div class="py-2">
        {{ $orders->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-4">
            <x-table.heading>Order #</x-table.heading>
            <x-table.heading>customer</x-table.heading>
            <x-table.heading class="text-center">delivery</x-table.heading>
            <x-table.heading class="text-right">picking list</x-table.heading>
        </x-table.header>
        @forelse($orders as $order)
            <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                <x-table.row class="text-center lg:text-left">
                    <p>{{ $order->number}}</p>
                    <p class="text-slate-500">{{ $order->created_at}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <div class="flex lg:items-start justify-center lg:justify-between">
                        <div>
                            <p>{{$order->customer->name}}</p>

                            <div class="pt-1 flex justify-between space-x-2">
                                <p
                                    @class([
                                        'text-xs',
                                        'text-pink-700 dark:text-pink-400' => $order->customer->type() === 'wholesale',
                                        'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                                    ])
                                >{{ $order->customer->type() }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $order->customer->salesperson->name ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row class="text-center">
                    <p>
                        <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery?->type }}</p>

                </x-table.row>
                <x-table.row class="text-center lg:text-right p-2">
                    <button class="button-success w-full lg:w-32 text-center"
                            wire:loading.attr="disabled"
                            wire:click="getPickingSlip({{$order}})"
                    >
                    <span class="pr-2"
                          wire:loading
                          wire:target="getPickingSlip"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                        Print
                    </button>
                    @if(file_exists(public_path("storage/pick-lists/$order->number.pdf")))
                        <p class="text-xs text-slate-400">Printed</p>
                    @endif
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>

</div>
