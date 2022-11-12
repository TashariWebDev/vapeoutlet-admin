<div>
    <div>
        <a
            class="link"
            href="{{ route('settings') }}"
        >back to settings</a>
    </div>

    <x-slide-over
        title="Add delivery option"
        wire:model.defer="showDeliveryCreateForm"
    >
        <form wire:submit.prevent="save">
            <div class="py-3">
                <x-input
                    type="text"
                    label="name/type"
                    wire:model.defer="delivery.type"
                />
            </div>
            <div class="py-3">
                <x-input
                    type="text"
                    label="description"
                    wire:model.defer="delivery.description"
                />
            </div>
            <div class="py-3">
                <x-input
                    type="text"
                    label="price"
                    wire:model.defer="delivery.price"
                />
            </div>
            <div class="py-3">
                <x-input
                    type="text"
                    label="waiver order value"
                    wire:model.defer="delivery.waiver_value"
                    placeholder="leave empty if not applicable"
                />
            </div>
            <div class="py-3">
                <x-select
                    label=""
                    wire:model.defer="delivery.province"
                >
                    @foreach ($provinces as $province)
                        <option
                            class="capitalize"
                            value="{{ $province }}"
                        >
                            {{ $province }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-3">
                <x-select
                    label=""
                    wire:model.defer="delivery.customer_type"
                >
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
                </x-select>
            </div>
            <div class="py-3 w-full">
                <div class="py-2 px-2 rounded-md bg-slate-100">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="selectable"
                    >
                        <input
                            class="text-green-500 rounded-full focus:ring-slate-200"
                            id="selectable"
                            type="checkbox"
                            wire:model.defer="delivery.selectable"
                        />
                        <span class="ml-3">Selectable</span>
                    </label>
                </div>
            </div>
            <div class="py-3">
                <button class="button-success">
                    <x-icons.save class="mr-3 w-5 h-5" />
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <header class="flex justify-start lg:justify-end">
        <button
            class="button-success"
            x-on:click="@this.call('edit','')"
        >
            <x-icons.plus class="mr-3 w-5 h-5" />
            add delivery
        </button>
    </header>

    <div class="py-6">
        <div
            class="hidden py-2 text-sm font-semibold text-white uppercase bg-white rounded-t border lg:grid lg:grid-cols-6 bg-gradient-slate">
            <div class="col-span-2 px-2 border-r">type</div>
            <div class="px-2 border-r">price</div>
            <div class="px-2 border-r">waiver amount</div>
            <div class="px-2 border-r">selectable</div>
            <div class="px-2 text-center">delete</div>
        </div>

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @forelse($deliveries as $delivery)
                <div
                    class="@if ($loop->last) rounded-b @endif grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 border text-sm bg-white md:py-1">
                    <div class="col-span-2 text-center border-r lg:py-2 lg:px-2 lg:text-left">
                        <div class="p-2 text-white lg:hidden bg-gradient-slate">
                            <p>type</p>
                        </div>
                        <div class="flex items-center p-2 text-center lg:block lg:text-left">
                            <button
                                class="capitalize link"
                                x-on:click="@this.call('edit',{{ $delivery->id }})"
                            >
                                {{ $delivery->type }}
                            </button>
                            <p class="ml-2 text-xs md:ml-0 text-slate-500">{{ $delivery->description }}</p>
                        </div>
                    </div>
                    <div class="text-center border-r lg:py-6 lg:px-2 lg:text-left">
                        <div class="p-2 text-white lg:hidden bg-gradient-slate">
                            <p>price</p>
                        </div>
                        <p class="p-2">R {{ number_format($delivery->price, 2) }}</p>
                    </div>
                    <div class="text-center border-r lg:py-6 lg:px-2 lg:text-left">
                        <div class="p-2 text-white lg:hidden bg-gradient-slate">
                            <p>phone</p>
                        </div>
                        <p class="p-2">R {{ number_format($delivery->waiver_value, 2) }}</p>
                    </div>
                    <div class="text-center border-r lg:py-6 lg:px-2">
                        <div class="p-2 text-white lg:hidden bg-gradient-slate">
                            <p>selectable</p>
                        </div>
                        @if ($delivery->selectable)
                            <div class="flex justify-center items-center py-2 space-x-2">
                                <x-icons.tick class="mr-2 w-5 h-5 text-green-500" />
                                Available on-line
                            </div>
                        @endif
                    </div>
                    <div class="text-center lg:py-4 lg:px-2">
                        <div class="p-2 text-white lg:hidden bg-gradient-slate">
                            <p>delete</p>
                        </div>
                        <div class="p-2">
                            <button
                                class="button-danger"
                                x-on:click="@this.call('delete',{{ $delivery->id }})"
                            >
                                <x-icons.cross class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-6">
                    <div class="py-10 text-center bg-white rounded-md">
                        <x-icons.truck class="mx-auto w-12 h-12 text-slate-400" />
                        <h3 class="mt-2 text-sm font-medium text-slate-900">No delivery options</h3>
                        <p class="mt-1 text-sm text-slate-500">Get started by creating a new delivery.</p>
                        <div class="mt-6">
                            <button
                                class="button-success"
                                type="button"
                                x-on:click="@this.call('edit','')"
                            >
                                <x-icons.plus
                                    class="mr-2 -ml-1 w-5 h-5 rounded-full ring-1 ring ring-white animate-pulse"
                                />
                                New delivery
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="py-6">
        {{ $deliveries->links() }}
    </div>
</div>
