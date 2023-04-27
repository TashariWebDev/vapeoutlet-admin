<div>
    <x-modal
        x-data="{ show: $wire.entangle('modal') }"
        x-cloak
    >

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New customer</h3>
        </div>

        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input.label for="name">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        autofocus
                        required
                    />
                    @error('name')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-input.label for="email">
                        Email
                    </x-input.label>
                    <x-input.text
                        id="email"
                        type="email"
                        wire:model.defer="email"
                        required
                    />
                    @error('email')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-input.label for="phone">
                        phone
                    </x-input.label>
                    <x-input.text
                        id="phone"
                        type="text"
                        wire:model.defer="phone"
                    />
                    @error('phone')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                @hasPermissionTo('upgrade customers')
                <div class="py-3 px-2 rounded-md bg-slate-100 dark:bg-slate-800">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium text-blue-500 uppercase dark:text-blue-500"
                        for="is_wholesale"
                    >
                        <input
                            class="text-blue-500 rounded-full focus:ring-slate-200"
                            id="is_wholesale"
                            type="checkbox"
                            wire:model.defer="is_wholesale"
                        />
                        <span class="ml-3">Wholesale</span>
                    </label>
                </div>
                @endhasPermissionTo
                <div class="py-3">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                    >
                        <x-icons.busy
                            target="save"
                            wire:loading
                        />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
