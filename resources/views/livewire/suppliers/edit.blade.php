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
        <div class="p-2 bg-white rounded-lg dark:bg-slate-800">
            <form wire:submit.prevent="editSupplier">
                <div class="py-3">
                    <x-form.input.label for="name">
                        Name
                    </x-form.input.label>
                    <x-form.input.text
                        id="Name"
                        type="text"
                        wire:model.defer="supplier.name"
                    />
                    @error('supplier.name')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="email">
                        Email
                    </x-form.input.label>
                    <x-form.input.text
                        id="Email"
                        type="email"
                        wire:model.defer="supplier.email"
                    />
                    @error('supplier.email')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="phone">
                        Phone
                    </x-form.input.label>
                    <x-form.input.text
                        idl="Phone"
                        type="text"
                        wire:model.defer="supplier.phone"
                    />
                    @error('supplier.phone')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="person">
                        Contact person
                    </x-form.input.label>
                    <x-form.input.text
                        type="text"
                        label="Contact person"
                        wire:model.defer="supplier.person"
                    />
                    @error('supplier.person')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="address_line_one">
                        Address line one
                    </x-form.input.label>
                    <x-form.input.text
                        id="address_line_one"
                        type="text"
                        wire:model.defer="supplier.address_line_one"
                    />
                    @error('supplier.address_line_one')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="address_line_two">
                        Address line two
                    </x-form.input.label>
                    <x-form.input.text
                        id="address_line_two"
                        type="text"
                        wire:model.defer="supplier.address_line_two"
                    />
                    @error('supplier.address_line_two')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="suburb">
                        Suburb
                    </x-form.input.label>
                    <x-form.input.text
                        id="suburb"
                        type="text"
                        wire:model.defer="supplier.suburb"
                    />
                    @error('supplier.address_line_suburb')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="city">
                        City
                    </x-form.input.label>
                    <x-form.input.text
                        id="city"
                        type="text"
                        wire:model.defer="supplier.city"
                    />
                    @error('supplier.city')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="country">
                        Country
                    </x-form.input.label>
                    <x-form.input.text
                        id="country"
                        type="text"
                        wire:model.defer="supplier.country"
                    />
                    @error('supplier.country')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>

                <div class="py-3">
                    <x-form.input.label for="postal_code">
                        Postal code
                    </x-form.input.label>
                    <x-form.input.text
                        id="postal_code"
                        type="text"
                        wire:model.defer="supplier.postal_code"
                    />
                    @error('supplier.postal_code')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
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
