<div>

    <button
        class="w-full button-danger"
        wire:click.prevent="$toggle('modal')"
    >
        Cancel order
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-500">Cancel this order?</h3>
        </div>
        <div class="flex items-center py-3 space-x-2">
            <button
                class="w-32 button-success"
                wire:loading.attr="disabled"
                wire:click="credit"
            >
                <span
                    class="pr-2"
                    wire:target="credit"
                    wire:loading
                ><x-icons.busy target="credit" /></span>
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
</div>
