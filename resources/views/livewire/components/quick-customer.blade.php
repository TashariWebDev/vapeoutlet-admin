<div>
    <div class="pr-4">
        <button
            class="button-success"
            wire:click="$toggle('customerModal')"
        >New customer
        </button>
    </div>

    <x-modal wire:model.defer="customerModal"
             title="New customer"
    >

        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input type="text"
                             wire:model.defer="name"
                             label="name"
                             required
                    />
                </div>
                <div class="py-2">
                    <x-input type="email"
                             wire:model.defer="email"
                             label="email"
                             required
                    />
                </div>
                <div class="py-3">
                    <x-input type="text"
                             wire:model.defer="phone"
                             label="phone"
                    />
                </div>
                @hasPermissionTo('upgrade customers')
                <div class="py-2 bg-slate-100 rounded-md px-2">
                    <label for="is_wholesale"
                           class="text-xs uppercase font-medium flex items-center space-x-2"
                    >
                        <input type="checkbox"
                               wire:model.defer="is_wholesale"
                               id="is_wholesale"
                               class="rounded-full text-green-500 focus:ring-slate-200"
                        />
                        <span class="ml-3">Wholesale</span>
                    </label>
                </div>
                @endhasPermissionTo
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>

    </x-modal>
</div>
