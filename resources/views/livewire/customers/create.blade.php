<div>
    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New customer</h3>
        </div>

        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-form.input.label for="name">
                        Name
                    </x-form.input.label>
                    <x-form.input.text
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        autofocus
                        required
                    />
                    @error('name')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-form.input.label for="email">
                        Email
                    </x-form.input.label>
                    <x-form.input.text
                        id="email"
                        type="email"
                        wire:model.defer="email"
                        required
                    />
                    @error('email')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-3">
                    <x-form.input.label for="phone">
                        phone
                    </x-form.input.label>
                    <x-form.input.text
                        id="phone"
                        type="text"
                        wire:model.defer="phone"
                    />
                    @error('phone')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                @hasPermissionTo('upgrade customers')
                    <div class="py-3 px-2 rounded-md bg-slate-100 dark:bg-slate-800">
                        <label
                            class="flex items-center space-x-2 text-xs text-teal-400 dark:text-teal-400 font-medium uppercase"
                            for="is_wholesale"
                        >
                            <input
                                class="text-teal-500 rounded-full focus:ring-slate-200"
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
