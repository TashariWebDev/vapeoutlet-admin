<div>
    <x-page-header>
        Edit supplier
    </x-page-header>

    <div class="pb-2">
        <a
            class="link"
            href="{{ route('suppliers') }}"
        >back to suppliers</a>
    </div>

    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <form wire:submit.prevent="editSupplier">
                <div class="py-3">
                    <x-input.label for="name">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="Name"
                        type="text"
                        wire:model.defer="supplier.name"
                    />
                    @error('supplier.name')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="email">
                        Email
                    </x-input.label>
                    <x-input.text
                        id="Email"
                        type="email"
                        wire:model.defer="supplier.email"
                    />
                    @error('supplier.email')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="phone">
                        Phone
                    </x-input.label>
                    <x-input.text
                        idl="Phone"
                        type="text"
                        wire:model.defer="supplier.phone"
                    />
                    @error('supplier.phone')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="person">
                        Contact person
                    </x-input.label>
                    <x-input.text
                        type="text"
                        label="Contact person"
                        wire:model.defer="supplier.person"
                    />
                    @error('supplier.person')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="address_line_one">
                        Address line one
                    </x-input.label>
                    <x-input.text
                        id="address_line_one"
                        type="text"
                        wire:model.defer="supplier.address_line_one"
                    />
                    @error('supplier.address_line_one')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="address_line_two">
                        Address line two
                    </x-input.label>
                    <x-input.text
                        id="address_line_two"
                        type="text"
                        wire:model.defer="supplier.address_line_two"
                    />
                    @error('supplier.address_line_two')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="suburb">
                        Suburb
                    </x-input.label>
                    <x-input.text
                        id="suburb"
                        type="text"
                        wire:model.defer="supplier.suburb"
                    />
                    @error('supplier.address_line_suburb')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="city">
                        City
                    </x-input.label>
                    <x-input.text
                        id="city"
                        type="text"
                        wire:model.defer="supplier.city"
                    />
                    @error('supplier.city')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="country">
                        Country
                    </x-input.label>
                    <x-input.text
                        id="country"
                        type="text"
                        wire:model.defer="supplier.country"
                    />
                    @error('supplier.country')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-input.label for="postal_code">
                        Postal code
                    </x-input.label>
                    <x-input.text
                        id="postal_code"
                        type="text"
                        wire:model.defer="supplier.postal_code"
                    />
                    @error('supplier.postal_code')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
