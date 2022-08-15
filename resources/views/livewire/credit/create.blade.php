<div x-data="{}">
    <x-loading-screen/>

    <x-modal title="Are you sure?" wire:model.defer="showConfirmModal">
        <div class="flex space-x-4 py-4">
            <button class="button-success" wire:loading.attr="disabled" wire:target="save"
                    x-on:click="$wire.call('process')"
            >
                <x-icons.tick class="w-5 h-5 mr-2"/>
                Yes! Process
            </button>
            <button class="button-secondary w-32"
                    x-on:click="$wire.set('showConfirmModal',false)"
            >
                <x-icons.cross class="w-5 h-5 mr-2"/>
                No
            </button>
        </div>
    </x-modal>

    <div>
        <div class="grid grid-col-1 md:grid-cols-4 gap-3 px-2 py-1 border-b pb-4 bg-white rounded-md">
            <div class="order-last md:order-first md:col-span-2">
                @if(!$this->credit->processed)
                    <div class="pb-3 grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <button class="button-success w-full"
                                x-on:click="@this.set('showProductSelectorForm',true)"
                        >
                            <x-icons.plus class="w-5 h-5 mr-2"/>
                            add products
                        </button>
                        <div></div>
                        <button class="button-danger w-full"
                                x-on:click="@this.call('cancel')"
                        >
                            <x-icons.cross class="w-5 h-5 mr-2"/>
                            cancel
                        </button>
                        <button class="button-success w-full"
                                x-on:click="@this.set('showConfirmModal',true)"
                        >
                            <x-icons.tick class="w-5 h-5 mr-2"/>
                            process
                        </button>
                    </div>
                @else
                    <div class="pb-3">
                        <button class="button-danger w-full" disabled
                        >Processed by {{$this->credit->created_by}} on {{ $this->credit->processed_date }}
                        </button>
                    </div>
                @endif
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl underline underline-offset-4 pl-4">
                    R {{ number_format($this->credit->getTotal(),2) }}
                </h1>
                <h2>
                    <span class="text-xs">vat</span> {{ number_format(vat($this->credit->getTotal()),2) }}
                </h2>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl">{{ $this->credit->number }}</h1>
                <a class="text-right font-bold underline underline-offset-2 text-green-600 hover:text-yellow-500"
                   href="{{ route('customers/show',$this->customer->id) }}">{{ $this->customer->name }}</a>
                <h2>{{ $this->credit->created_at->format('Y-M-d') }}</h2>
            </div>
        </div>

        <x-slide-over x-cloak wire:ignore.self="searchQuery" title="Select products"
                      wire:model.defer="showProductSelectorForm">
            <div>
                <x-input type="search" label="search products" wire:model="searchQuery"/>
            </div>

            <div class="pt-4">
                <form wire:submit.prevent="addProducts">
                    <div class="py-6">
                        <button class="button-success">
                            <x-icons.plus class="w-5 h-5 mr-2"/>
                            add
                        </button>
                    </div>
                    <fieldset class="space-y-2">
                        @forelse($products as $product)
                            <label class="relative flex items-start bg-gray-100 py-2 px-4 rounded-md">
                                <div>
                                    <input id="{{$product->id}}" aria-describedby="product"
                                           wire:model="selectedProducts"
                                           wire:key="{{$product->id}}"
                                           value="{{$product->id}}"
                                           type="checkbox"
                                           class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="flex ml-3 w-full items-center">
                                    <div class="rounded-full">
                                        <img src="{{ asset($product->image) }}" alt=""
                                             class="w-10 h-10 rounded-full mr-3">
                                    </div>
                                    <div class="text-sm">
                                        <div for="{{$product->id}}"
                                             class="font-semibold text-gray-700">
                                            {{ $product->brand }} {{ $product->name }}
                                            <p class="text-gray-700 text-xs">{{ $product->sku }}</p>
                                        </div>
                                        <div class="flex flex-wrap items-center divide-x">
                                            @foreach($product->features as $feature)
                                                <p id="features" class="text-gray-500 text-xs px-1">
                                                    {{ $feature->name }}
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div
                                class="w-full bg-gray-100 rounded-md flex justify-center items-center inset-0 py-6 px-2 text-center">
                                <p>No results</p>
                            </div>
                        @endforelse
                    </fieldset>
                </form>
            </div>
            <div class="py-3">
                {{ $products->links() }}
            </div>
        </x-slide-over>

        <div class="py-2 grid grid-cols-1 gap-y-2">
            @foreach($this->credit->items as $item)
                <div>
                    <div class="w-full bg-white grid grid-cols-2 md:grid-cols-5 gap-4 rounded-md py-2">
                        <div class="col-span-2 px-2 py-4">
                            <h4 class="font-bold">
                                {{ $item->product->brand }} {{ $item->product->name }}
                            </h4>
                            <div class="flex flex-wrap space-x-1 divide-x items-center">
                                @foreach($item->product->features as $feature)
                                    <p class="text-xs text-gray-600 px-0.5"
                                    > {{ $feature->name }}</p>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-400">{{ $item->product->sku }}</p>
                        </div>
                        @if(!$this->credit->processed)
                            <div class="px-2 py-4">
                                <x-input-number type="number" label="Update price"
                                                value="{{$item->price}}"
                                                x-on:keydown.enter="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div class="px-2 py-6">
                                <p class="font-bold">
                                    {{number_format($item->price,2)}}
                                </p>
                            </div>
                        @endif
                        @if(!$this->credit->processed)
                            <div class="px-2 py-4">
                                <x-input-number type="number" label="Update qty"
                                                value="{{$item->qty}}"
                                                x-on:keydown.enter="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div class="px-2 py-6">
                                <p class="font-bold">
                                    {{$item->qty}}
                                </p>
                            </div>
                        @endif
                        <div class="px-4 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-right">
                                    {{ number_format($item->line_total,2) }}
                                </p>
                            </div>
                            @if(!$this->credit->processed)
                                <div class="hidden md:block">
                                    <button wire:loading.attr="disabled"
                                            x-on:click="@this.call('deleteItem','{{$item->id}}')"
                                            class="button-danger">remove
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="px-2 md:hidden">
                            @if(!$this->credit->processed)
                                <button wire:loading.attr="disabled"
                                        x-on:click="@this.call('deleteItem','{{$item->id}}')"
                                        class="button-danger w-full">
                                    remove
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
