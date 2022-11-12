<div>

    <div class="pb-5">
        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-400">Customers</h3>
    </div>

    <div
        class="grid grid-cols-1 gap-y-4 py-3 px-2 rounded-lg shadow lg:grid-cols-3 lg:gap-x-3 bg-slate-100 dark:bg-slate-900">
        <div>
            <x-form.input.label for="search">
                Search
            </x-form.input.label>
            <x-form.input.text
                id="search"
                type="search"
                autofocus
                wire:model="searchTerm"
                placeholder="Search by invoice number or customer"
            />
        </div>
    </div>

    <div class="py-2">
        {{ $orders->links() }}
    </div>

    {{-- Desktop --}}
    <div class="hidden lg:block">
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
                        <p>{{ $order->number }}</p>
                        <p class="text-slate-500">{{ $order->created_at }}</p>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-left">
                        <div class="flex justify-center lg:justify-between lg:items-start">
                            <div>
                                <p>{{ $order->customer->name }}</p>

                                <div class="flex justify-between pt-1 space-x-2">
                                    <p @class([
                                        'text-xs',
                                        'text-pink-700 dark:text-pink-400' =>
                                            $order->customer->type() === 'wholesale',
                                        'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                                    ])>{{ $order->customer->type() }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $order->customer->salesperson->name ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row class="text-center">
                        <p>
                            <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery?->type }}
                        </p>

                    </x-table.row>
                    <x-table.row class="p-2 text-center lg:text-right">
                        <button
                            class="w-auto button-success"
                            wire:loading.attr="disabled"
                            wire:target="getPickingSlip({{ $order->id }})"
                            wire:click="getPickingSlip({{ $order->id }})"
                        >
                            <span
                                class="pr-2"
                                wire:loading
                                wire:target="getPickingSlip({{ $order->id }})"
                            >
                                <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                            </span>
                            Print
                        </button>
                        @if (file_exists(public_path("storage/pick-lists/$order->number.pdf")))
                            <p class="text-xs text-slate-500">Printed</p>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>

    {{-- mobile --}}
    <div class="grid grid-cols-1 gap-y-4 px-1 lg:hidden">
        @forelse($orders as $order)
            <div class="grid grid-cols-2 text-xs bg-white rounded dark:bg-slate-900">
                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('orders/show', $order->id) }}"
                    >{{ $order->number }}</a>
                    <p class="text-xs text-slate-500">
                        {{ $order->created_at->format('Y-m-d') }}
                    </p>
                </div>

                <div class="p-1">
                    <a
                        class="link"
                        href="{{ route('customers/show', $order->customer->id) }}"
                    >{{ $order->customer->name }}</a>

                    <div class="pt-1">
                        <p @class([
                            'text-xs',
                            'text-pink-700 dark:text-pink-400' =>
                                $order->customer->type() === 'wholesale',
                            'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                        ])>{{ $order->customer->type() }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $order->customer->salesperson->name ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="col-span-2 p-1 py-1 mt-3 w-full">
                    <p class="font-semibold text-slate-500">{{ $order->delivery->type ?? '' }}</p>
                </div>

                <div class="col-span-3 mt-3 w-full">
                    @if (file_exists(public_path("storage/pick-lists/$order->number.pdf")))
                        <p class="text-xs text-slate-500">Printed</p>
                    @endif
                    <button
                        class="w-full button-success"
                        wire:loading.attr="disabled"
                        wire:target="getPickingSlip({{ $order->id }})"
                        wire:click="getPickingSlip({{ $order->id }})"
                    >
                        <span
                            class="pr-2"
                            wire:loading
                            wire:target="getPickingSlip({{ $order->id }})"
                        >
                            <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                        </span>
                        Print
                    </button>
                </div>

            </div>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </div>
</div>
