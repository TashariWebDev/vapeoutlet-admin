<div>

    <x-slide-over x-data="{ show: $wire.entangle('showDeliveryCreateForm') }">
        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-input.label for="type">
                    Type
                </x-input.label>
                <x-input.text
                    id="type"
                    type="text"
                    wire:model="delivery.type"
                />
                @error('delivery.type')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="description">
                    Description
                </x-input.label>
                <x-input.text
                    id="description"
                    type="text"
                    wire:model="delivery.description"
                />
                @error('delivery.description')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="price">
                    Price
                </x-input.label>
                <x-input.text
                    id="price"
                    type="text"
                    wire:model="delivery.price"
                />
                @error('delivery.price')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="waiver">
                    Waiver value
                </x-input.label>
                <x-input.text
                    id="waiver"
                    type="text"
                    wire:model="delivery.waiver_value"
                    placeholder="leave empty if not applicable"
                />
                @error('delivery.waiver_value')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="province">
                    Province
                </x-input.label>
                <x-input.select
                    id="province"
                    wire:model="delivery.province"
                >
                    <option value="">Choose</option>
                    @foreach ($provinces as $province)
                        <option
                            class="capitalize"
                            value="{{ $province }}"
                        >
                            {{ $province }}
                        </option>
                    @endforeach
                </x-input.select>
                @error('delivery.province')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-input.label for="customer_type">
                    Customer type
                </x-input.label>
                <x-input.select
                    id="customer_type"
                    wire:model="delivery.customer_type"
                >
                    <option value="">Choose</option>
                    <option
                        class="capitalize"
                        value="retail"
                    >
                        Retail
                    </option>
                    <option
                        class="capitalize"
                        value="wholesale"
                    >
                        Wholesale
                    </option>
                </x-input.select>
                @error('delivery.customer_type')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="py-2 w-full">
                <div class="py-2 px-2 rounded-md bg-slate-100 dark:bg-slate-700">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="selectable"
                    >
                        <input
                            class="rounded-full text-sky-500 focus:ring-slate-200"
                            id="selectable"
                            type="checkbox"
                            wire:model="delivery.selectable"
                        />
                        <span class="ml-3">Selectable</span>
                    </label>
                    @error('delivery.selectable')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
            </div>
            <div class="py-2">
                <button class="button-success">
                    <x-icons.busy target="save" />
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <div class="py-3 px-2 bg-white rounded-lg shadow-md dark:bg-slate-900">
        <header class="flex justify-between py-6 px-2">
            <x-page-header>
                Delivery settings
            </x-page-header>
            <button
                class="button-success"
                wire:click="edit"
            >
                add delivery
            </button>
        </header>

        <div class="py-3 px-2">
            {{ $deliveries->links() }}
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-5">
                <x-table.heading>type</x-table.heading>
                <x-table.heading class="text-right">price</x-table.heading>
                <x-table.heading class="text-right">waiver amount</x-table.heading>
                <x-table.heading class="text-center">selectable</x-table.heading>
                <x-table.heading class="text-right">Action</x-table.heading>
            </x-table.header>
            @forelse($deliveries as $delivery)
                <x-table.body class="grid grid-cols-2 lg:grid-cols-5">
                    <x-table.row>
                        <div>
                            <button
                                class="capitalize link"
                                wire:click="edit('{{ $delivery->id }}')"
                            >
                                {{ $delivery->type }}
                            </button>
                            <p class="ml-2 text-xs md:ml-0 text-slate-600 dark:text-slate-300">
                                {{ $delivery->description }}
                            </p>
                        </div>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <p class="p-2 text-slate-600 dark:text-slate-300">R {{ number_format($delivery->price, 2) }}
                        </p>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <p class="p-2 text-slate-600 dark:text-slate-300">
                            R {{ number_format($delivery->waiver_value, 2) }}</p>
                    </x-table.row>
                    <x-table.row>
                        @if ($delivery->selectable)
                            <div class="flex justify-center items-center py-2 space-x-2">
                                <p class="text-sky-600 dark:text-sky-300">Available on-line</p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-right">
                        <div>
                            <button
                                class="button-danger"
                                wire:click="delete('{{ $delivery->id }}')"
                            >
                                delete
                            </button>
                        </div>
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
