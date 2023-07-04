<div class="relative">
    <x-modal x-data="{ show: $wire.entangle('statusModal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">
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
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Edit this order?</h3>
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

    <div class="p-2 bg-white rounded-lg dark:bg-slate-900">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="grid grid-cols-1 gap-x-3 lg:grid-cols-3">
                <div class="pt-1">
                    <p class="text-sm font-bold uppercase dark:text-white text-slate-900">
                        {{ $this->order->number }} | {{ $this->order->sales_channel->name }}
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-500">{{ $this->order->created_at }}</p>
                    @isset($this->order->delivery_type_id)
                        <div class="flex justify-between">
                            <p class="text-sm capitalize text-slate-500 dark:text-slate-500">
                                {{ $this->order->delivery?->type }}
                            </p>
                            <p class="text-sm capitalize text-slate-600 dark:text-slate-300">
                                R {{ number_format($this->order->delivery_charge,2) }}
                            </p>
                        </div>
                    @endisset
                    <div class="flex col-span-2 justify-between p-1 mt-3 bg-slate-100 dark:bg-slate-950">
                        <p class="text-sm font-bold dark:text-white text-slate-900">
                            Total: R {{ number_format($this->order->getTotal(), 2) }}
                        </p>
                        <p class="text-sm font-bold dark:text-white text-slate-900">
                            Count: {{ $this->order->items->sum('qty') }}
                        </p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('customers/show',$this->order->customer->id) }}"
                       class="link"
                    >{{ $this->order->customer->name }}
                    </a>
                    <div class="leading-3">
                        <p class="text-sm font-semibold capitalize text-slate-500 dark:text-slate-500">{{ $this->order->customer->phone }}</p>
                        <p class="text-sm font-semibold lowercase text-slate-500 dark:text-slate-500">{{ $this->order->customer->email }}</p>
                    </div>
                </div>
                <div>
                    @isset($this->order->address_id)
                        <div class="pt-1 text-sm font-semibold leading-4 capitalize text-slate-500 dark:text-slate-500">
                            @isset($this->order->customer->company)
                                <p>{{ $this->order->customer->company }}</p>
                            @endisset
                            <p>{{ $this->order->address?->line_one }}</p>
                            <p>{{ $this->order->address?->line_two }}</p>
                            <p>{{ $this->order->address?->suburb }} </p>
                            <p>{{ $this->order->address?->city }}</p>
                            <p>{{ $this->order->address?->province }}, {{ $this->order->address?->postal_code }}</p>
                        </div>
                    @endisset
                </div>
            </div>
            <div>
                <div class="grid grid-cols-2 col-span-2 gap-2 mt-2 lg:grid-cols-3 lg:mt-0">
                    <div>
                        <livewire:orders.note :order="$this->order" />
                    </div>
                    <div>
                        @if (
                            $this->order->status != 'shipped' &&
                                $this->order->status != 'completed' &&
                                $this->order->status != 'cancelled')
                            <livewire:orders.waybill :order="$this->order" />
                        @endif
                    </div>
                    <div>
                        @hasPermissionTo('edit orders')
                        @if (
                            $this->order->status != 'shipped' &&
                                $this->order->status != 'completed' &&
                                $this->order->status != 'cancelled')
                            <livewire:orders.cancel :order="$this->order" />
                        @endif
                        @endhasPermissionTo
                    </div>
                    <div>
                        @if (
                            $this->order->status != 'shipped' &&
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
                            <p class="font-extrabold text-rose-600">CANCELLED</p>
                        @endif
                        @if ($this->order->status == 'completed')
                            <p class="font-extrabold text-rose-600">COMPLETED</p>
                        @endif
                    </div>
                    <div>
                        @if (
                            $this->order->status != 'shipped' &&
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
                        @hasPermissionTo('edit orders')
                        @if (
                            $this->order->status != 'shipped' &&
                                $this->order->status != 'completed' &&
                                $this->order->status != 'cancelled')
                            <button
                                class="w-full text-xs button-warning"
                                x-on:click="@this.set('showEditModal',true)"
                            >
                                edit
                            </button>
                        @endif
                        @endhasPermissionTo
                    </div>
                    <div>
                        @if (
                            $this->order->status != 'shipped' &&
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
        </div>
    </div>

    <div class="mt-2 bg-white rounded-lg dark:bg-slate-900">


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
                    <x-table.row class="col-span-2 mb-2 lg:mb-0">
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
                        @if (auth()->user()->hasPermissionTo('edit pricing'))
                            <x-input.label class="lg:hidden">
                                Price
                            </x-input.label>
                            <x-input.text
                                type="number"
                                value="{{ $item->price }}"
                                wire:keyup.debounce.1500ms="updatePrice({{ $item->id }},$event.target.value)"
                                pattern="[0-9]*"
                                inputmode="numeric"
                                step="0.01"
                            />

                        @else
                            <x-input.label class="lg:hidden">
                                Price
                            </x-input.label>
                            <x-input.text
                                class="w-full rounded-md bg-slate-300 text-slate-900"
                                type="number"
                                value="{{ $item->price }}"
                                pattern="[0-9]*"
                                inputmode="numeric"
                                step="0.01"
                                disabled
                            />
                        @endif
                    </x-table.row>
                    <x-table.row>
                        <x-input.label class="lg:hidden">
                            Discount
                        </x-input.label>
                        <x-input.text
                            class="w-full rounded-md bg-slate-300 text-slate-900"
                            type="number"
                            value="{{ $item->discount }}"
                            inputmode="numeric"
                            pattern="[0-9]"
                            step="0.01"
                            disabled
                        />
                    </x-table.row>
                    <x-table.row class="mt-1 lg:mt-0">
                        <x-input.label class="lg:hidden">
                            Qty
                        </x-input.label>
                        <x-input.text
                            class="w-full rounded-md bg-slate-300 text-slate-900"
                            type="number"
                            value="{{ $item->qty }}"
                            inputmode="numeric"
                            pattern="[0-9]"
                            min="1"
                            disabled
                        />
                    </x-table.row>
                    <x-table.row class="mt-1 lg:mt-0">
                        <x-input.label class="lg:hidden">
                            Line total
                        </x-input.label>
                        <x-input.text
                            class="w-full rounded-md bg-slate-300 text-slate-900"
                            type="number"
                            value="{{ $item->line_total }}"
                            inputmode="numeric"
                            pattern="[0-9]"
                            step="0.01"
                            disabled
                        />
                    </x-table.row>
                </x-table.body>
            @endforeach
        </x-table.container>
    </div>

    {{-- Order Notes --}}
    <div class="p-4 mt-4 bg-white rounded-lg dark:bg-slate-900">

        @foreach ($this->order->notes as $note)
            <div class="py-3">
                <div>
                    @if ($note->customer_id)
                        <p class="text-xs uppercase dark:text-white text-slate-900">
                            {{ $note->customer?->name }}
                            on {{ $note->created_at->format('d-m-y H:i') }}</p>
                    @else
                        <p class="text-xs uppercase dark:text-white text-slate-900">{{ $note->user?->name }}
                            on {{ $note->created_at->format('d-m-y H:i') }}</p>
                    @endif
                </div>
                @if ($note->body)
                    <div class="p-1 mt-2 rounded-md bg-slate-100 dark:bg-slate-700">
                        <p class="text-sm capitalize dark:text-white text-slate-900">{{ $note->body }}</p>
                    </div>
                @endif
                @if ($note->user_id === auth()->id())
                    <div>
                        <button
                            class="text-xs text-rose-500"
                            x-on:click="@this.call('removeNote',{{ $note->id }})"
                        >remove
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
