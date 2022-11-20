<div>

    <button
        class="w-full button-success"
        wire:loading.attr="disabled"
        wire:click="$toggle('modal')"
    >
        <x-icons.busy target="save" />
        Waybill
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Ship this order?</h3>
        </div>

        <form wire:submit.prevent="save">
            <div class="py-4">
                <x-form.input.label>
                    Waybill No:
                </x-form.input.label>
                <x-form.input.text
                    id="waybill"
                    type="text"
                    wire:model.defer="waybill"
                />
            </div>

            <div class="pt-4">
                <button
                    class="button-success"
                    wire:loading.attr="disabled"
                    wire:target="save"
                >
                    <x-icons.busy target="save" />
                    Add waybill
                </button>
            </div>
        </form>
    </x-modal>
</div>
