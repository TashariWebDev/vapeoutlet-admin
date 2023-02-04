<div>

    <button
        class="mt-5 w-full lg:w-auto button-success"
        wire:click.prevent="$toggle('modal')"
    >
        Create Sales Channel
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New sales channel</h3>
        </div>

        <div>
            <div>
                <div class="py-2">
                    <x-input.label for="name">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        required
                        autocomplete="off"
                    />
                    @error('name')
                        <x-input.error>{{ $message }}</x-input.error>
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
