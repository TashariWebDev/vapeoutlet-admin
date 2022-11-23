<div>
    <button
        class="w-full button-success"
        wire:loading.attr="disabled"
        wire:click="$toggle('modal')"
    >
        <span
            class="pr-2"
            wire:loading
            wire:target="modal"
        ><x-icons.busy target="modal" /></span>
        Note
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New note</h3>
        </div>
        <form wire:submit.prevent="save">

            <div class="py-3">
                <x-input.label for="body">
                    Note
                </x-input.label>
                <x-input.textarea
                    id="body"
                    wire:model.defer="body"
                ></x-input.textarea>
            </div>

            <div>
                <div class="py-2 px-2 rounded-md bg-slate-100">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="is_private"
                    >
                        <input
                            class="text-teal-500 rounded-full focus:ring-slate-200"
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
</div>
