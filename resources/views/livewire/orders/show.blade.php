<div>

    <x-modal
        title="Do you want to ship this order?"
        wire:model.defer="showWaybillModal"
    >
        <form wire:submit.prevent="addWaybill">
            <div class="py-4">
                <x-input
                    id="waybill"
                    type="text"
                    label="waybill"
                    wire:model.defer="waybill"
                />
            </div>

            <div class="pt-4">
                <button class="button-success">Add waybill</button>
            </div>
        </form>
    </x-modal>

    <div class="py-2">
        <a
            class="link"
            href="{{ route('orders') }}"
        >back to orders</a>
    </div>

    <div
        class="grid grid-cols-2 gap-x-2 gap-y-2 p-3 mb-2 w-full bg-white rounded-md lg:grid-cols-6 lg:gap-y-0 dark:bg-slate-900">
        <div>
            <ul>
                <li>
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->number }}</p>
                </li>
                <li>
                    <p class="text-xs text-slate-600 dark:text-slate-500">{{ $this->order->created_at }}</p>
                </li>
                <li>
                    <p class="text-xs font-bold uppercase text-slate-600 dark:text-slate-400">{{ $this->order->status }}
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-400">
                        R {{ number_format($this->order->getTotal(), 2) }}
                    </p>
                </li>
                <li class="flex items-center space-x-2">
                    <span><x-icons.truck class="w-3 h-3 text-slate-600 dark:text-slate-400" /></span>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        R {{ number_format($this->order->delivery_charge, 2) }}
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-400">{{ $this->order->customer->name }}
                    </p>
                </li>
                @isset($this->order->customer->company)
                    <p class="text-xs text-slate-600 dark:text-slate-500">{{ $this->order->customer->company }}</p>
                @endisset
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    @isset($this->order->address_id)
                        <div class="text-xs font-semibold capitalize text-slate-600 dark:text-slate-400">
                            <p>{{ $this->order->address->line_one }}</p>
                            <p>{{ $this->order->address->line_two }}</p>
                            <p>{{ $this->order->address->suburb }}, {{ $this->order->address->city }},</p>
                            <p>{{ $this->order->address->province }}, {{ $this->order->address->postal_code }}</p>
                        </div>
                    @endisset
                </li>
            </ul>
        </div>
        <div class="grid grid-cols-1 gap-1 lg:grid-cols-2">
            <button
                class="w-full button-success"
                wire:loading.attr="disabled"
                wire:click="toggleNoteForm"
            >
                <span
                    class="pr-2"
                    wire:loading
                    wire:target="toggleNoteForm"
                ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                Add note
            </button>
            @hasPermissionTo('complete orders')
                @if ($this->order->status === 'shipped')
                    <button
                        class="w-full button-success"
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
            @if ($this->order->status != 'shipped' &&
                $this->order->status != 'completed' &&
                $this->order->status != 'cancelled')
                <button
                    class="w-full button-success"
                    wire:loading.attr="disabled"
                    wire:click="toggleWaybillForm"
                >
                    <span
                        class="pr-2"
                        wire:loading
                        wire:target="toggleWaybillForm"
                    ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                    Add waybill
                </button>

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

        <div class="grid grid-cols-1 gap-1">
            @if ($this->order->status != 'shipped' &&
                $this->order->status != 'completed' &&
                $this->order->status != 'cancelled')
                <div>
                    <button
                        class="w-full text-xs button-danger"
                        x-on:click="@this.set('cancelConfirmation',true)"
                    >
                        credit this order
                    </button>
                </div>
                <div>
                    <button
                        class="w-full text-xs button-warning"
                        x-on:click="@this.set('showEditModal',true)"
                    >
                        edit
                    </button>
                </div>
                <div>
                    <label>
                        <select
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
                        </select>
                    </label>
                </div>
            @endif
        </div>
    </div>

    <x-modal wire:model.defer="statusModal">
        Are your sure your want to update the status?
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

    <x-modal
        title="Add note"
        wire:model.defer="addNoteForm"
    >
        <form wire:submit.prevent="saveNote">
            <div>
                <label for="note">Note</label>
            </div>
            <textarea
                class="w-full h-20 rounded-md border-slate=400"
                id="note"
                wire:model.defer="note"
            ></textarea>

            <div>
                <div class="py-2 px-2 rounded-md bg-slate-100">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="is_private"
                    >
                        <input
                            class="text-green-500 rounded-full focus:ring-slate-200"
                            id="is_private"
                            type="checkbox"
                            wire:model.defer="is_private"
                        />
                        <span class="ml-3">Is private</span>
                    </label>
                </div>
            </div>

            <div class="py-2">
                <button class="button-success">Save</button>
            </div>
        </form>
    </x-modal>

    <x-modal
        title="Are your sure?"
        wire:model.defer="cancelConfirmation"
    >
        <div class="flex items-center py-3 space-x-2">
            <button
                class="button-danger"
                wire:loading.attr="disabled"
                wire:click="credit"
            >
                <span
                    class="pr-2"
                    wire:loading="credit"
                ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                credit this order
            </button>
        </div>
        <p
            class="text-xs text-slate-600"
            wire:loading="credit"
        >Crediting this invoice please wait..</p>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <x-modal
        title="Are your sure?"
        wire:model.defer="showEditModal"
    >
        <div class="flex items-center py-3 space-x-2">
            <button
                class="button-success"
                wire:loading.attr="disabled"
                wire:click="edit"
            >
                <span
                    class="pr-2"
                    wire:loading="edit"
                ><x-icons.refresh class="w-3 h-3 animate-spin-slow" /></span>
                edit order
            </button>
        </div>
        <p class="text-xs text-slate-600">This action is non reversible</p>
    </x-modal>

    <x-table.container>
        <x-table.header class="grid grid-cols-6">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="text-right">price</x-table.heading>
            <x-table.heading class="text-right">dis<span class="hidden lg:block">count</span></x-table.heading>
            <x-table.heading class="text-right">qty</x-table.heading>
            <x-table.heading class="text-right">total</x-table.heading>
        </x-table.header>
        @foreach ($this->order->items as $item)
            <x-table.body class="grid grid-cols-6">
                <x-table.row class="col-span-2">
                    <div class="flex justify-start items-center">
                        <div>
                            <p class="text-xs">{{ $item->product->sku }}</p>
                            <p class="text-xs font-semibold">{{ $item->product->brand }} {{ $item->product->name }}
                            </p>
                            <div class="flex flex-wrap">
                                @foreach ($item->product->features as $feature)
                                    <p class="pr-1 text-xs font-semibold">
                                        {{ $feature->name }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right whitespace-nowrap">
                        R {{ number_format($item->price, 2) }}
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right whitespace-nowrap">
                        R {{ $item->discount }}
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right">
                        {{ $item->qty }}
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right whitespace-nowrap">
                        R {{ $item->line_total }}
                    </div>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>

    <div class="p-4 mt-4 bg-white rounded-md dark:bg-slate-900">

        @foreach ($this->order->notes as $note)
            <div class="pb-2">
                <div>
                    @if ($note->customer_id)
                        <p class="text-xs uppercase text-slate-600 dark:text-slate-400">{{ $note->customer?->name }}
                            on {{ $note->created_at }}</p>
                    @else
                        <p class="text-xs uppercase text-slate-600 dark:text-slate-400">{{ $note->user?->name }}
                            on {{ $note->created_at }}</p>
                    @endif
                </div>
                <div class="p-1">
                    <p class="text-sm capitalize text-slate-600 dark:text-slate-400">{{ $note->body }}</p>
                </div>
                @if ($note->user_id === auth()->id())
                    <div>
                        <button
                            class="text-xs text-red-500"
                            x-on:click="@this.call('removeNote',{{ $note->id }})"
                        >remove
                        </button>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>
