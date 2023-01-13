<div>
    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-1 gap-y-4 py-3 px-2 lg:grid-cols-3 lg:gap-x-3">
            <div>
                <x-input.label for="search">
                    Search
                </x-input.label>
                <x-input.text
                    id="search"
                    type="search"
                    autofocus
                    autocomplete="off"
                    wire:model="searchQuery"
                    placeholder="Search by invoice number or customer"
                />
                <x-input.helper>
                    Query Time {{ round($queryTime, 3) }} ms
                </x-input.helper>
            </div>
        </div>

        <div class="py-2">
            {{ $orders->links() }}
        </div>

        {{-- Desktop --}}
        <div class="hidden lg:block">
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-3">
                    <x-table.heading>Order #</x-table.heading>
                    <x-table.heading>customer</x-table.heading>
                    <x-table.heading class="text-right">picking list</x-table.heading>
                </x-table.header>
                @forelse($orders as $order)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-3">
                        <x-table.row class="text-center lg:text-left">
                            <p>{{ $order->number }}</p>
                            <p class="text-slate-600 dark:text-slate-500">{{ $order->created_at->format('d-m-y H:i') }}
                            </p>
                        </x-table.row>
                        <x-table.row class="text-center lg:text-left">
                            <div class="flex justify-center lg:justify-between lg:items-start">
                                <div>
                                    <p>{{ $order->customer->name }}</p>

                                    <div class="flex justify-between pt-1 space-x-2">
                                        <p @class([
                                            'text-xs',
                                            'text-rose-700 dark:text-rose-400' =>
                                                $order->customer->type() === 'wholesale',
                                            'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                                        ])>{{ $order->customer->type() }}</p>
                                        <p class="text-xs text-slate-600 dark:text-slate-500">
                                            {{ $order->customer->salesperson->name ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
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
                                <p class="text-xs text-slate-600 dark:text-slate-500">Printed</p>
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
                        <p class="text-xs text-slate-600 dark:text-slate-500">
                            {{ $order->created_at->format('d-m-y H:i') }}
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
                                'text-rose-700 dark:text-rose-400' =>
                                    $order->customer->type() === 'wholesale',
                                'text-blue-700 dark:text-blue-400' => $order->customer->type() === 'retail',
                            ])>{{ $order->customer->type() }}</p>
                            <p class="text-xs text-slate-600 dark:text-slate-500">
                                {{ $order->customer->salesperson->name ?? '' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-span-2 p-1 py-1 mt-3 w-full">
                        <p class="font-semibold text-slate-600 dark:text-slate-500">{{ $order->delivery->type ?? '' }}
                        </p>
                    </div>

                    <div class="col-span-3 mt-3 w-full">
                        @if (file_exists(public_path("storage/pick-lists/$order->number.pdf")))
                            <p class="text-xs text-slate-600 dark:text-slate-500">Printed</p>
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
</div>
