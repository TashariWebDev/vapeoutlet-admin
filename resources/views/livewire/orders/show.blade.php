<div class="relative">
    <x-modal x-data="{ show: $wire.entangle('statusModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">
                Are your sure your want to update the status?
            </h3>
        </div>
        <div class="flex justify-start items-center py-3 space-x-4">
            <button
                class="button-success"
                @click="$wire.call('updateOrderStatus')"
                wire:click="$toggle('statusModal')"
            >Set status to {{ $selectedStatus }}</button>
            <button
                class="button-danger"
                @click="$wire.set('selectedStatus','')"
                wire:click="$toggle('statusModal')"
            >cancel
            </button>
        </div>
    </x-modal>

    <x-modal x-data="{ show: $wire.entangle('showEditModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Edit this order?</h3>
        </div>
        <div class="flex items-center py-3 space-x-2">
            <button
                class="w-32 button-success"
                wire:loading.attr="disabled"
                wire:click="edit"
            >
                <span
                    class="pr-2"
                    wire:loading="edit"
                ><x-icons.busy target="edit" /></span>
                Yes!
            </button>
            <button
                class="w-32 button-danger"
                x-on:click="show = !show"
            >
                No
            </button>
        </div>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <div class="bg-white rounded-lg shadow dark:bg-slate-800">
        <div class="grid grid-cols-2 gap-y-2 p-2 lg:grid-cols-4 lg:gap-y-0 lg:gap-x-3">
            <div class="col-span-2 lg:col-span-1">
                <p class="text-xs font-bold dark:text-teal-400 text-slate-500">{{ $this->order->number }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $this->order->updated_at }}</p>
                @isset($this->order->delivery_type_id)
                    <p class="text-xs capitalize text-slate-500 dark:text-slate-400">{{ $this->order->delivery?->type }}
                    </p>
                @endisset
                <div class="flex col-span-2 justify-between p-2 mt-2 rounded bg-slate-50 dark:bg-slate-700">
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Total: R {{ number_format($this->order->getTotal(), 2) }}
                        <span class="pl-3">(Delivery:{{ number_format($this->order->delivery_charge, 2) }})</span>
                    </p>
                    <p class="text-xs font-bold text-teal-500 dark:text-teal-400">
                        Count: {{ $this->order->items_count }}
                    </p>
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1">
                <p class="font-semibold text-teal-500 dark:text-teal-400">{{ $this->order->customer->name }}
                    @isset($this->order->customer->company)
                        <span>| {{ $this->order->customer->company }}</span>
                    @endisset
                </p>
                @isset($this->order->address_id)
                    <div class="text-xs font-semibold text-teal-500 capitalize dark:text-teal-400">
                        <p>{{ $this->order->address?->line_one }}</p>
                        <p>{{ $this->order->address?->line_two }}</p>
                        <p>{{ $this->order->address?->suburb }}, {{ $this->order->address?->city }},</p>
                        <p>{{ $this->order->address?->province }}, {{ $this->order->address?->postal_code }}</p>
                    </div>
                @endisset
            </div>

            <div class="grid grid-cols-2 col-span-2 gap-2 lg:grid-cols-3">
                <div>
                    <livewire:orders.note :order="$this->order" />
                </div>
                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <livewire:orders.waybill :order="$this->order" />
                    @endif
                </div>
                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <livewire:orders.cancel :order="$this->order" />
                    @endif
                </div>
                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <button
                            class="w-full button-success"
                            wire:loading.attr="disabled"
                            wire:click="getPickingSlip"
                        >
                            <span
                                class="pr-2"
                                wire:loading
                                wire:target="getPickingSlip"
                            ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                            Picking Slip
                        </button>
                    @endif
                    @if ($this->order->status == 'cancelled')
                        <p class="font-extrabold text-pink-600">CANCELLED</p>
                    @endif
                    @if ($this->order->status == 'completed')
                        <p class="font-extrabold text-pink-600">COMPLETED</p>
                    @endif
                </div>
                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <button
                            class="w-full button-success"
                            wire:loading.attr="disabled"
                            wire:click="getDeliveryNote"
                        >
                            <span
                                class="pr-2"
                                wire:loading
                                wire:target="getDeliveryNote"
                            ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                            Delivery Note
                        </button>
                    @endif
                </div>

                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <button
                            class="w-full text-xs button-warning"
                            x-on:click="@this.set('showEditModal',true)"
                        >
                            edit
                        </button>
                    @endif
                </div>
                <div>
                    @if ($this->order->status != 'shipped' &&
                        $this->order->status != 'completed' &&
                        $this->order->status != 'cancelled')
                        <label>
                            <x-input.select
                                class="w-full rounded-md"
                                wire:change="$toggle('statusModal')"
                                @change="$wire.set('selectedStatus',event.target.value)"
                                wire:model.defer="status"
                            >
                                <option value="received">Received</option>
                                <option value="processed">Processed</option>
                                <option value="packed">Packed</option>
                                <option value="shipped">Shipped</option>
                                <option value="completed">Completed</option>
                            </x-input.select>
                        </label>
                    @endif
                </div>
                <div>
                    @hasPermissionTo('complete orders')
                        @if ($this->order->status === 'shipped')
                            <button
                                class="mt-2 w-full button-success"
                                wire:loading.attr="disabled"
                                wire:click="pushToComplete()"
                                wire:target="pushToComplete()"
                            >
                                <span
                                    class="pr-2"
                                    wire:loading
                                    wire:target="pushToComplete()"
                                ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                                Complete
                            </button>
                        @endif
                    @endhasPermissionTo
                </div>
            </div>
        </div>

        <x-table.container>
            <x-table.header class="hidden grid-cols-6 lg:grid">
                <x-table.heading class="col-span-2">Product</x-table.heading>
                <x-table.heading class="lg:text-right">price</x-table.heading>
                <x-table.heading class="lg:text-right">discount</x-table.heading>
                <x-table.heading class="lg:text-right">qty</x-table.heading>
                <x-table.heading class="lg:text-right">Line total</x-table.heading>
            </x-table.header>

            @foreach ($this->order->items as $item)
                <x-table.body
                    class="grid lg:grid-cols-6"
                    wire:key="'item-table-'{{ $item->id }}"
                >
                    <x-table.row class="col-span-2">
                        <div class="flex justify-start items-center">
                            <div>
                                <x-product-listing-simple
                                    :product="$item->product"
                                    wire:key="'order-item-'{{ $item->id }}"
                                />
                            </div>
                        </div>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-900 bg-slate-400"
                                type="number"
                                value="{{ $item->price }}"
                                disabled
                                pattern="[0-9]*"
                                inputmode="numeric"
                                step="0.01"
                            />
                        </label>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-900 bg-slate-400"
                                type="number"
                                value="{{ $item->discount }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>
                    <x-table.row>

                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-900 bg-slate-400"
                                type="number"
                                value="{{ $item->qty }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                min="1"
                                disabled
                            />
                        </label>
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-input.text
                                class="w-full rounded-md text-slate-900 bg-slate-400"
                                type="number"
                                value="{{ $item->line_total }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                disabled
                            />
                        </label>
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>

    {{-- Order Notes --}}
    <div class="p-4 mt-4 bg-white rounded-md shadow dark:bg-slate-800">

        @foreach ($this->order->notes as $note)
            <div class="py-3">
                <div>
                    @if ($note->customer_id)
                        <p class="text-xs text-teal-500 uppercase dark:text-teal-400">{{ $note->customer?->name }}
                            on {{ $note->created_at->format('d-m-y H:i') }}</p>
                    @else
                        <p class="text-xs text-teal-500 uppercase dark:text-teal-400">{{ $note->user?->name }}
                            on {{ $note->created_at->format('d-m-y H:i') }}</p>
                    @endif
                </div>
                @if ($note->body)
                    <div class="p-1 mt-2 rounded-md bg-slate-100 dark:bg-slate-700">
                        <p class="text-sm text-teal-500 capitalize dark:text-teal-400">{{ $note->body }}</p>
                    </div>
                @endif
                @if ($note->user_id === auth()->id())
                    <div>
                        <button
                            class="text-xs text-pink-500"
                            x-on:click="@this.call('removeNote',{{ $note->id }})"
                        >remove
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
