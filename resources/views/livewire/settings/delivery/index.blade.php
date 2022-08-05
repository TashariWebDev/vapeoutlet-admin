<div>

    <x-slide-over title="Add delivery option" wire:model.defer="showDeliveryCreateForm">
        <form wire:submit.prevent="save">
            <div class="py-3">
                <x-input type="text" label="name/type" wire:model.defer="delivery.type"/>
            </div>
            <div class="py-3">
                <x-input type="text" label="description" wire:model.defer="delivery.description"/>
            </div>
            <div class="py-3">
                <x-input type="text" label="price" wire:model.defer="delivery.price"/>
            </div>
            <div class="py-3">
                <x-input type="text" label="waiver order value" wire:model.defer="delivery.waiver_value"
                         placeholder="leave empty if not applicable"/>
            </div>
            <div class="py-3">
                <x-select label="restrict to province" wire:model.defer="delivery.province">
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" class="capitalize">
                            {{ $province }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="py-3">
                <x-select label="restrict to customer type"
                          wire:model.defer="delivery.customer_type">
                    <option value="retail" class="capitalize">
                        Retail
                    </option>
                    <option value="wholesale" class="capitalize">
                        Wholesale
                    </option>
                </x-select>
            </div>
            <div class="py-3 w-full">
                <div class="py-2 bg-gray-100 rounded-md px-2">
                    <label for="selectable" class="text-xs uppercase font-medium flex items-center space-x-2">
                        <input type="checkbox" wire:model.defer="delivery.selectable" id="selectable"
                               class="rounded-full text-green-500 focus:ring-gray-200"/>
                        <span class="ml-3">Selectable</span>
                    </label>
                </div>
            </div>
            <div class="py-3">
                <button class="button-success">
                    <x-icons.save class="w-5 h-5 mr-3"/>
                    save
                </button>
            </div>
        </form>
    </x-slide-over>

    <header class="flex justify-start lg:justify-end">
        <button class="button-success"
                x-on:click="@this.call('edit','')"
        >
            <x-icons.plus class="w-5 h-5 mr-3"/>
            add delivery
        </button>
    </header>

    <div class="py-6">
        <div
            class="hidden lg:grid lg:grid-cols-6 border text-sm bg-white rounded-t text-sm font-semibold uppercase py-2 bg-gradient-gray text-white">
            <div class="border-r px-2 col-span-2">type</div>
            <div class="border-r px-2">price</div>
            <div class="border-r px-2">waiver amount</div>
            <div class="border-r px-2 ">selectable</div>
            <div class="px-2 text-center">delete</div>
        </div>

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @forelse($deliveries as $delivery)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 border text-sm bg-white md:py-1
                        @if($loop->last) rounded-b @endif">
                    <div class="border-r lg:py-2 lg:px-2 text-center lg:text-left col-span-2">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>type</p>
                        </div>
                        <div class="lg:block flex items-center text-center lg:text-left p-2">
                            <button class="capitalize link"
                                    x-on:click="@this.call('edit',{{$delivery->id}})"
                            >
                                {{ $delivery->type }}
                            </button>
                            <p class="text-gray-500 text-xs ml-2 md:ml-0">{{ $delivery->description }}</p>
                        </div>
                    </div>
                    <div class="border-r lg:py-6 lg:px-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>price</p>
                        </div>
                        <p class="p-2">R {{  number_format($delivery->price,2) }}</p>
                    </div>
                    <div class="border-r lg:py-6 lg:px-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>phone</p>
                        </div>
                        <p class="p-2">R {{  number_format($delivery->waiver_value,2) }}</p>
                    </div>
                    <div class="border-r lg:py-6 lg:px-2 text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>selectable</p>
                        </div>
                        @if($delivery->selectable)
                            <div class="flex justify-center items-center space-x-2 py-2">
                                <x-icons.tick class="text-green-500 w-5 h-5 mr-2"/>
                                Available on-line
                            </div>
                        @endif
                    </div>
                    <div class="lg:py-4 lg:px-2 text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>delete</p>
                        </div>
                        <div class="p-2">
                            <button class="button-danger"
                                    x-on:click="@this.call('delete',{{$delivery->id}})"
                            >
                                <x-icons.cross class="w-5 h-5"/>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-6">
                    <div class="text-center py-10 bg-white rounded-md">
                        <x-icons.truck class="mx-auto h-12 w-12 text-gray-400"/>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No delivery options</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new delivery.</p>
                        <div class="mt-6">
                            <button type="button"
                                    class="button-success" x-on:click="@this.call('edit','')">
                                <x-icons.plus
                                    class="-ml-1 mr-2 h-5 w-5 animate-pulse rounded-full ring ring-white ring-1"/>
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
