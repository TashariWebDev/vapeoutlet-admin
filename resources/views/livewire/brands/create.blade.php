<div>

    <button wire:click.prevent="$toggle('modal')">
        <x-icons.plus class="w-10 h-10 text-teal-500 hover:text-teal-600" />
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New brand</h3>
        </div>

        <div>
            <div>
                <div class="py-2">
                    <x-form.input.label for="name">
                        Name
                    </x-form.input.label>
                    <x-form.input.text
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        required
                    />
                    @error('name')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-form.input.label for="logo">
                        Logo
                    </x-form.input.label>
                    <x-form.input.text
                        id="logo"
                        type="file"
                        wire:model.defer="logo"
                        required
                    />
                    @error('logo')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        wire:click="save"
                    >
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </div>
        </div>
    </x-modal>
</div>
