<div>

    <x-modal title="Do you want to ship this order?"
             wire:model.defer="showWaybillModal"
    >
        <form wire:submit.prevent="addWaybill">
            <div class="py-4">
                <x-input type="text"
                         id="waybill"
                         label="waybill"
                         wire:model.defer="waybill"
                />
            </div>

            <div class="pt-4">
                <button class="button-success">Add waybill</button>
            </div>
        </form>
    </x-modal>

    <div class="p-3 mb-2 bg-white dark:bg-slate-900 w-full rounded-md grid grid-cols-2 lg:grid-cols-6 gap-x-2 gap-y-2 lg:gap-y-0">
        <div>
            <ul>
                <li>
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->number }}</p>
                </li>
                <li><p class="text-xs text-slate-600 dark:text-slate-500">{{ $this->order->created_at }}</p></li>
                <li>
                    <p class="text-xs text-slate-600 dark:text-slate-400 uppercase font-bold">{{ $this->order->status }}</p>
                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-400">
                        R {{ number_format($this->order->getTotal(),2)}}
                    </p>
                </li>
                <li class="flex items-center space-x-2">
                    <span><x-icons.truck class="text-slate-600 dark:text-slate-400 w-3 h-3"/></span>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        R {{ number_format($this->order->delivery_charge,2)}}
                    </p>
                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-400">{{ $this->order->customer->name }}</p>
                </li>
                @isset($this->order->customer->company)
                    <p class="text-xs
                       text-slate-600
                       dark:text-slate-500"
                    >{{ $this->order->customer->company}}</p>
                @endisset
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    @isset($this->order->address_id)
                        <div class="text-xs capitalize font-semibold text-slate-600 dark:text-slate-400">
                            <p>{{$this->order->address->line_one }}</p>
                            <p>{{ $this->order->address->line_two }}</p>
                            <p>{{ $this->order->address->suburb }}, {{ $this->order->address->city }},</p>
                            <p>{{ $this->order->address->province }}, {{ $this->order->address->postal_code }}</p>
                        </div>
                    @endisset
                </li>
            </ul>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-1">
            <button class="button-success w-full"
                    wire:loading.attr="disabled"
                    wire:click="toggleNoteForm"
            >
                    <span class="pr-2"
                          wire:loading
                          wire:target="toggleNoteForm"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                Add note
            </button>
            @hasPermissionTo('complete orders')
            @if($this->order->status === 'shipped')
                <button class="button-success w-full"
                        wire:loading.attr="disabled"
                        wire:click="pushToComplete()"
                        wire:target="pushToComplete()"
                >
                    <span class="pr-2"
                          wire:loading
                          wire:target="pushToComplete()"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                    Complete
                </button>
            @endif
            @endhasPermissionTo
            @if($this->order->status != 'shipped' && $this->order->status != 'completed' && $this->order->status != 'cancelled')
                <button class="button-success w-full"
                        wire:loading.attr="disabled"
                        wire:click="toggleWaybillForm"
                >
                    <span class="pr-2"
                          wire:loading
                          wire:target="toggleWaybillForm"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                    Add waybill
                </button>

                <button class="button-success w-full"
                        wire:loading.attr="disabled"
                        wire:click="getPickingSlip"
                >
                    <span class="pr-2"
                          wire:loading
                          wire:target="getPickingSlip"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                    Picking Slip
                </button>

                <button class="button-success w-full"
                        wire:loading.attr="disabled"
                        wire:click="getDeliveryNote"
                >
                    <span class="pr-2"
                          wire:loading
                          wire:target="getDeliveryNote"
                    ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                    Delivery Note
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-1">
            @if($this->order->status != 'shipped' && $this->order->status != 'completed' && $this->order->status != 'cancelled')
                <div>
                    <button class="text-xs button-danger w-full"
                            x-on:click="@this.set('cancelConfirmation',true)"
                    >
                        credit this order
                    </button>
                </div>
                <div>
                    <button class="text-xs button-warning w-full"
                            x-on:click="@this.set('showEditModal',true)"
                    >
                        edit
                    </button>
                </div>
                <div>
                    <label>
                        <select wire:model="status"
                                class="w-full  rounded-md"
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

    <x-modal title="Add note"
             wire:model.defer="addNoteForm"
    >
        <form wire:submit.prevent="saveNote">
            <div>
                <label for="note">Note</label>
            </div>
            <textarea wire:model.defer="note"
                      id="note"
                      class="border-slate=400 rounded-md w-full h-20"
            ></textarea>

            <div>
                <div class="py-2 bg-slate-100 rounded-md px-2">
                    <label for="is_private"
                           class="text-xs uppercase font-medium flex items-center space-x-2"
                    >
                        <input type="checkbox"
                               wire:model.defer="is_private"
                               id="is_private"
                               class="rounded-full text-green-500 focus:ring-slate-200"
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


    <x-modal title="Are your sure?"
             wire:model.defer="cancelConfirmation"
    >
        <div class="flex items-center space-x-2 py-3">
            <button class="button-danger"
                    wire:loading.attr="disabled"
                    wire:click="credit"
            >
                <span class="pr-2"
                      wire:loading="credit"
                ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                credit this order
            </button>
        </div>
        <p class="text-slate-600 text-xs"
           wire:loading="credit"
        >Crediting this invoice please wait..</p>
        <p class="text-slate-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?"
             wire:model.defer="showEditModal"
    >
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success"
                    wire:loading.attr="disabled"
                    wire:click="edit"
            >
                <span class="pr-2"
                      wire:loading="edit"
                ><x-icons.refresh class="h-3 w-3 animate-spin-slow"/></span>
                edit order
            </button>
        </div>
        <p class="text-slate-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-table.container>
        <x-table.header class="grid grid-cols-4">
            <x-table.heading class="col-span-2">Product</x-table.heading>
            <x-table.heading class="lg:text-right">price</x-table.heading>
            <x-table.heading class="lg:text-right">qty</x-table.heading>
        </x-table.header>
        @foreach($this->order->items as $item)
            <x-table.body class="grid grid-cols-4">
                <x-table.row class="col-span-2">
                    <div class="flex justify-start items-center">
                        <div>
                            <p class="text-xs">{{ $item->product->sku }}</p>
                            <p class="text-xs font-semibold">{{ $item->product->brand }} {{ $item->product->name }}</p>
                            <div class="flex flex-wrap">
                                @foreach($item->product->features as $feature)
                                    <p class="text-xs font-semibold text-xs pr-1">
                                        {{ $feature->name }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right">
                        R {{ number_format($item->price,2) }}
                    </div>
                </x-table.row>
                <x-table.row>
                    <div class="text-right">
                        {{ $item->qty }}
                    </div>
                </x-table.row>
            </x-table.body>
        @endforeach
    </x-table.container>


    <div class="mt-4 bg-white dark:bg-slate-900 rounded-md p-4">

        @foreach($this->order->notes as $note)
            <div class="pb-2">
                <div>
                    @if($note->customer_id)
                        <p class="text-xs text-slate-600 dark:text-slate-400 uppercase">{{ $note->customer?->name }}
                            on {{ $note->created_at }}</p>
                    @else
                        <p class="text-xs text-slate-600 dark:text-slate-400 uppercase">{{ $note->user?->name }}
                            on {{ $note->created_at }}</p>
                    @endif
                </div>
                <div class="p-1">
                    <p class="capitalize text-sm text-slate-600 dark:text-slate-400">{{ $note->body }}</p>
                </div>
                @if($note->user_id === auth()->id())
                    <div>
                        <button class="text-red-500 text-xs"
                                x-on:click="@this.call('removeNote',{{$note->id}})"
                        >remove
                        </button>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>
