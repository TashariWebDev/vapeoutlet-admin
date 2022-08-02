<div x-data="{}">
    <x-loading-screen/>

    <x-modal title="Are you sure?" wire:model.defer="showConfirmModal">
        <div class="flex space-x-4 py-4">
            <button class="button-success"
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
                @if(!$this->purchase->processed)
                    <div class="pb-3 grid grid-cols-1 lg:grid-cols-2 gap-2">
                        @if($this->purchase->total != $this->purchase->amount)
                            <button class="button-success w-full"
                                    x-on:click="@this.set('showProductSelectorForm',true)"
                            >
                                <x-icons.plus class="w-5 h-5 mr-2"/>
                                add products
                            </button>
                        @endif
                        <button class="button-danger w-full"
                                x-on:click="@this.call('cancel')"
                        >
                            <x-icons.cross class="w-5 h-5 mr-2"/>
                            cancel
                        </button>
                        @if($this->purchase->total === $this->purchase->amount)
                            <button class="button-success w-full md:w-32 animate-pulse"
                                    x-on:click="@this.set('showConfirmModal',true)"
                            >
                                <x-icons.tick class="w-5 h-5 mr-2"/>
                                process
                            </button>
                        @endif
                    </div>
                @else
                    <div class="pb-3">
                        <button class="button-danger w-full" disabled
                        >Processed by {{$this->purchase->creator->name}} on {{ $this->purchase->processed_date }}
                        </button>
                    </div>
                @endif
                <div class="bg-gray-200 rounded-md px-2">
                    <p>
                        <span
                            class="@if($this->purchase->total === $this->purchase->amount)text-green-600 @else text-red-600 @endif">
                            {{$this->purchase->total}} {{$this->purchase->currency}}
                        </span>
                        <span class="font-bold">/ {{$this->purchase->amount}} {{$this->purchase->currency}}</span>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl underline underline-offset-4 pl-4">
                    {{ money($this->purchase->total_cost_in_zar()) }}
                </h1>
                <h2>
                    <span class="text-xs">shipping</span> {{ money($this->purchase->shipping_cost()) }}
                    <span class="text-xs">vat</span> {{ money(vat($this->purchase->total_cost_in_zar())) }}
                </h2>
                <h2>
                    <span class="text-xs">amount</span>
                    {{ $this->purchase->amount_converted_to_zar() }} ZAR |
                    {{$this->purchase->amount}} {{ $this->purchase->currency }}
                </h2>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl">{{ $this->purchase->invoice_no }}</h1>
                <a class="text-right font-bold underline underline-offset-2 text-green-600 hover:text-yellow-500"
                   href="{{ route('suppliers/show',$this->purchase->supplier->id) }}">{{ $this->purchase->supplier->name }}</a>
                <h2>{{ $this->purchase->date->format('Y-M-d') }}</h2>
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
                                <div class="flex justify-between ml-3 w-full items-center">
                                    <div class="text-sm">
                                        <div for="{{$product->id}}"
                                             class="font-semibold text-gray-700">{{ $product->brand }} {{ $product->name }}</div>
                                        <div class="flex space-x-2 items-center">
                                            <p class="text-gray-700 text-xs">{{ $product->sku }}</p>
                                            @foreach($product->features as $feature)
                                                <p id="features" class="text-gray-500 text-xs">{{ $feature->name }}
                                                    @if(!$loop->last) <span> | </span>@endif
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="rounded-full">
                                        <img src="{{ asset($product->image) }}" alt=""
                                             class="w-10 h-10 rounded-full">
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

        <x-table.container>
            <x-table.header class="hidden lg:grid grid-cols-1 lg:grid-cols-4">
                <x-table.heading class="text-center lg:text-left">Product</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Price</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Qty</x-table.heading>
                <x-table.heading class="text-center lg:text-right">Subtotal</x-table.heading>
            </x-table.header>
            @foreach($this->purchase->items as $item)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row class="text-center lg:text-left">
                        <p class="text-xs text-gray-400">{{ $item->product->sku }}</p>
                        <h4 class="font-bold">
                            {{ $item->product->brand }} {{ $item->product->name }}
                        </h4>
                        <div class="flex flex-wrap justify-center lg:justify-start items-center">
                            @foreach($item->product->features as $feature)
                                <p class="text-xs text-gray-600 border-r pr-1 @if(!$loop->first) pl-1 @endif"
                                > {{ $feature->name }}</p>
                            @endforeach
                        </div>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if(!$this->purchase->processed)
                            <div>
                                <x-input-number type="number" label="Update price"
                                                value="{{$item->price}}"
                                                x-on:keydown.enter="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updatePrice',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{number_format($item->price,2)}} {{ $this->purchase->currency }}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        @if(!$this->purchase->processed)
                            <div>
                                <x-input-number type="number" label="Update qty"
                                                value="{{$item->qty}}"
                                                x-on:keydown.enter="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:keydown.tab="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                                x-on:blur="$wire.call('updateQty',{{$item->id}},$event.target.value)"
                                />
                            </div>
                        @else
                            <div>
                                <p class="font-bold">
                                    {{$item->qty}}
                                </p>
                            </div>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right">
                        {{ number_format($item->line_total,2) }} {{$this->purchase->currency}}
                        @if(!$this->purchase->processed)
                            <button wire:loading.attr="disabled"
                                    x-on:click="@this.call('deleteItem','{{$item->id}}')"
                                    class="button-danger w-full">
                                remove
                            </button>
                        @endif
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>
</div>
