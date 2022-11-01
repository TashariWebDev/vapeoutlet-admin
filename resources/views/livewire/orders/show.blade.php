<div>
    <div class="w-full bg-white dark:bg-slate-900 rounded-md p-6 mb-3 grid grid-cols-1 lg:grid-cols-3">
        <div>
            <p class="font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->number }}</p>
            <p class="text-xs text-slate-500">{{ $this->order->created_at }}</p>
            <p class="font-bold py-2 text-slate-600 dark:text-slate-400">
                R {{ number_format($this->order->getTotal(),2)}}</p>
            <p class="font-bold text-xs pt-2 text-slate-600 dark:text-slate-400">
                Processed By:
            </p>
            <p class="font-bold text-xs pb-2">
                {{ $this->order->processed_by}}
            </p>
        </div>

        <div>
            <p class="font-semibold text-slate-600 dark:text-slate-400">{{ $this->order->customer->name }}
                @isset($this->order->customer->company)
                    <span>| {{ $this->order->customer->company}}</span>
                @endisset
            </p>
            @isset($this->order->address_id)
                <div class="text-xs capitalize font-semibold text-slate-600 dark:text-slate-400">
                    <p>{{$this->order->address->line_one }}</p>
                    <p>{{ $this->order->address->line_two }}</p>
                    <p>{{ $this->order->address->suburb }}, {{ $this->order->address->city }},</p>
                    <p>{{ $this->order->address->province }}, {{ $this->order->address->postal_code }}</p>
                </div>
            @endisset
            @isset($this->order?->delivery_type_id)
                <p class="py-2 capitalize text-slate-600 dark:text-slate-400">{{ $this->order?->delivery->type }}</p>
            @endisset
        </div>
        <div class="flex items-start justify-between">
            @if($this->order->status == 'cancelled')
                <div>
                    <h1 class="text-3xl font-extrabold text-red-700">CANCELLED</h1>
                </div>
            @endif
            @if($this->order->status == 'shipped')
                <div>
                    <button class="button-success"
                            x-on:click="@this.call('pushToComplete')"
                    >Complete order
                    </button>
                </div>
            @endif
            <div class="flex justify-end">
                <button class="rounded-full p-2 ring ring-green-500"
                        x-on:click="@this.set('addNoteForm',true)"
                >
                    <x-icons.edit class="text-green-500 hover:text-green-600 w-5 h-5"/>
                </button>
            </div>
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
                    x-on:click="@this.call('cancel')"
            >cancel order
            </button>
        </div>
        <p class="text-slate-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?"
             wire:model.defer="showEditModal"
    >
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success"
                    x-on:click="@this.call('edit')"
            >
                edit order
            </button>
        </div>
        <p class="text-slate-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="Are your sure?"
             wire:model.defer="showConfirmModal"
    >
        <div class="flex items-center space-x-2 py-3">
            <button class="button-success"
                    x-on:click="@this.call('pushToWarehouse')"
            >
                process order
            </button>
        </div>
        <p class="text-slate-600 text-xs">This action is non reversible</p>
    </x-modal>

    <x-modal title="select an address"
             wire:model.defer="chooseAddressForm"
    >
        <label>
            <select x-on:change="@this.call('updateAddress',$event.target.value)"
                    class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
            >
                <option value="">Choose</option>
                @foreach($this->order->customer->addresses as $address)
                    <option value="{{$address->id}}"
                            class="capitalize"
                    >
                        {{$address->line_one }}
                        {{ $address->line_two }}
                        {{ $address->suburb }},
                        {{ $address->city }},
                        {{ $address->province }},
                        {{ $address->postal_code }}
                    </option>
                @endforeach
            </select>
        </label>
    </x-modal>

    <x-modal title="select an delivery option"
             wire:model.defer="chooseDeliveryForm"
    >
        <label>
            <select x-on:change="@this.call('updateDelivery',$event.target.value)"
                    class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
            >
                <option value="">Choose</option>
                @foreach($deliveryOptions as $delivery)
                    <option value="{{$delivery->id}}"
                            class="capitalize"
                    >
                        {{$delivery->description }}
                        {{ number_format($delivery->price,2) }}
                    </option>
                @endforeach
            </select>
        </label>
    </x-modal>

    @if($this->order->status == 'received' && $this->order->items->count() > 0)
        <div wire:loading.class="hidden"
             wire:target="pushToWarehouse"
             class="grid grid-cols-1 lg:grid-cols-5 space-y-2 lg:space-y-0 lg:space-x-2 py-2"
        >
            <div>
                <button class="text-xs button-success w-full h-full"
                        x-on:click="@this.set('chooseDeliveryForm',true)"
                >
                    <x-icons.plus class="w-5 h-5 mr-3"/>
                    delivery option
                </button>
            </div>
            <div>
                <button class="text-xs button-success w-full h-full"
                        x-on:click="@this.set('chooseAddressForm',true)"
                >
                    <x-icons.plus class="w-5 h-5 mr-3"/>
                    billing address
                </button>
            </div>
            <div>
                <button class="text-xs button-danger w-full h-full"
                        x-on:click="@this.set('cancelConfirmation',true)"
                >
                    <x-icons.cross class="w-5 h-5 mr-3"/>
                    cancel
                </button>
            </div>
            <div>
                <button class="text-xs button-warning w-full h-full"
                        x-on:click="@this.set('showEditModal',true)"
                >
                    <x-icons.edit class="w-5 h-5 mr-3"/>
                    edit
                </button>
            </div>
            <div>
                <button class="text-xs button-warning w-full h-full"
                        x-on:click="@this.set('showConfirmModal',true)"
                >
                    <x-icons.warehouse class="w-5 h-5 mr-3"/>
                    push to warehouse
                </button>
            </div>
        </div>
    @endif

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
