<div>
    <div class="w-full md:w-1/3">
        <form wire:submit.prevent="editSupplier">
            <div class="py-3">
                <x-input type="text" label="Name" wire:model.defer="supplier.name"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Email" wire:model.defer="supplier.email"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Phone" wire:model.defer="supplier.phone"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Contact person" wire:model.defer="supplier.person"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Address line one" wire:model.defer="supplier.address_line_one"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Address line two" wire:model.defer="supplier.address_line_two"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Suburb" wire:model.defer="supplier.suburb"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="City" wire:model.defer="supplier.city"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Country" wire:model.defer="supplier.country"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Postal code" wire:model.defer="supplier.postal_code"/>
            </div>

            <div class="py-3">
                <button class="button-success">
                    <x-icons.save class="w-5 h-5 mr-2"/>
                    save
                </button>
            </div>
        </form>
    </div>
</div>
