<div>

    <x-slide-over x-data="{ show: $wire.entangle('showDeliveryCreateForm') }">
        <form wire:submit.prevent="save">
            <div class="py-2">
                <x-form.input.label for="type">
                    Type
                </x-form.input.label>
                <x-form.input.text
                    id="type"
                    type="text"
                    wire:model.defer="delivery.type"
                />
                @error('delivery.type')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="description">
                    Description
                </x-form.input.label>
                <x-form.input.text
                    id="description"
                    type="text"
                    wire:model.defer="delivery.description"
                />
                @error('delivery.description')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="price">
                    Price
                </x-form.input.label>
                <x-form.input.text
                    id="price"
                    type="text"
                    wire:model.defer="delivery.price"
                />
                @error('delivery.price')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="waiver">
                    Waiver value
                </x-form.input.label>
                <x-form.input.text
                    id="waiver"
                    type="text"
                    wire:model.defer="delivery.waiver_value"
                    placeholder="leave empty if not applicable"
                />
                @error('delivery.waiver_value')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="province">
                    Province
                </x-form.input.label>
                <x-form.input.select
                    id="province"
                    wire:model.defer="delivery.province"
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
                </x-form.input.select>
                @error('delivery.province')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2">
                <x-form.input.label for="customer_type">
                    Customer type
                </x-form.input.label>
                <x-form.input.select
                    id="customer_type"
                    wire:model.defer="delivery.customer_type"
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
                </x-form.input.select>
                @error('delivery.customer_type')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>
            <div class="py-2 w-full">
                <div class="py-2 px-2 rounded-md bg-slate-100 dark:bg-slate-700">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="selectable"
                    >
                        <input
                            class="text-teal-500 rounded-full focus:ring-slate-200"
                            id="selectable"
                            type="checkbox"
                            wire:model.defer="delivery.selectable"
                        />
                        <span class="ml-3">Selectable</span>
                    </label>
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

    <div class="py-3 px-2 bg-white rounded-lg shadow dark:bg-slate-800">
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
                            <p class="ml-2 text-xs md:ml-0 text-slate-500 dark:text-slate-400">
                                {{ $delivery->description }}
                            </p>
                        </div>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <p class="p-2 text-slate-500 dark:text-slate-400">R {{ number_format($delivery->price, 2) }}
                        </p>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <p class="p-2 text-slate-500 dark:text-slate-400">
                            R {{ number_format($delivery->waiver_value, 2) }}</p>
                    </x-table.row>
                    <x-table.row>
                        @if ($delivery->selectable)
                            <div class="flex justify-center items-center py-2 space-x-2">
                                <p class="text-blue-600 dark:text-blue-300">Available on-line</p>
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
