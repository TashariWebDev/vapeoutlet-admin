<div>
    <button wire:click.prevent="$toggle('modal')">
        <x-icons.plus class="w-10 h-10 text-teal-500 hover:text-teal-600" />
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">New supplier</h3>
        </div>

        <div>
            <div class="py-2">
                <x-form.input.label for="name">
                    name
                </x-form.input.label>
                <x-form.input.text
                    id="Name"
                    type="text"
                    wire:model.defer="name"
                />
                @error('name')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="email">
                    email
                </x-form.input.label>
                <x-form.input.text
                    id="email"
                    type="email"
                    wire:model.defer="email"
                />
                @error('email')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="phone">
                    phone
                </x-form.input.label>
                <x-form.input.text
                    id="Phone"
                    type="text"
                    wire:model.defer="phone"
                />
                @error('phone')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="person">
                    Contact person
                </x-form.input.label>
                <x-form.input.text
                    id="Contact person"
                    type="text"
                    wire:model.defer="person"
                />
                @error('person')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="line_one">
                    Address line one
                </x-form.input.label>
                <x-form.input.text
                    id="line_one"
                    type="text"
                    wire:model.defer="address_line_one"
                />
                @error('address_line_one')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="line_two">
                    Address line two
                </x-form.input.label>
                <x-form.input.text
                    id="line_two"
                    type="text"
                    wire:model.defer="address_line_two"
                />
                @error('address_line_two')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="suburb">
                    Suburb
                </x-form.input.label>
                <x-form.input.text
                    id="suburb"
                    type="text"
                    wire:model.defer="suburb"
                />
                @error('suburb')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="city">
                    City
                </x-form.input.label>
                <x-form.input.text
                    id="city"
                    type="text"
                    wire:model.defer="city"
                />
                @error('city')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="postal_code">
                    Postal code
                </x-form.input.label>
                <x-form.input.text
                    id="postal_code"
                    type="text"
                    wire:model.defer="postal_code"
                />
                @error('postal_code')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-form.input.label for="country">
                    Country
                </x-form.input.label>
                <x-form.input.text
                    id="country"
                    type="text"
                    wire:model.defer="country"
                />
                @error('country')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-2">
                <button
                    class="button-success"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    wire:click.prevent="save"
                >
                    <x-icons.busy target="save" />
                    save
                </button>
            </div>
        </div>
    </x-modal>
</div>
