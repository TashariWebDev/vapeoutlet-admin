<div>
    <div class="w-full md:w-1/3">
        <form wire:submit.prevent="addSupplier">
            <div class="py-3">
                <x-input type="text" label="Name" wire:model.defer="name"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Email" wire:model.defer="email"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Phone" wire:model.defer="phone"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Contact person" wire:model.defer="person"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Address line one" wire:model.defer="address_line_one"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Address line one" wire:model.defer="address_line_two"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Suburb" wire:model.defer="suburb"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="City" wire:model.defer="city"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Country" wire:model.defer="country"/>
            </div>

            <div class="py-3">
                <x-input type="text" label="Postal code" wire:model.defer="postal_code"/>
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
