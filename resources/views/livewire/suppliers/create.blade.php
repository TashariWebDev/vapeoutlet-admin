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
                <x-input.label for="name">
                    name
                </x-input.label>
                <x-input.text
                    id="Name"
                    type="text"
                    wire:model.defer="name"
                />
                @error('name')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="email">
                    email
                </x-input.label>
                <x-input.text
                    id="email"
                    type="email"
                    wire:model.defer="email"
                />
                @error('email')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="phone">
                    phone
                </x-input.label>
                <x-input.text
                    id="Phone"
                    type="text"
                    wire:model.defer="phone"
                />
                @error('phone')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="person">
                    Contact person
                </x-input.label>
                <x-input.text
                    id="Contact person"
                    type="text"
                    wire:model.defer="person"
                />
                @error('person')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="line_one">
                    Address line one
                </x-input.label>
                <x-input.text
                    id="line_one"
                    type="text"
                    wire:model.defer="address_line_one"
                />
                @error('address_line_one')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="line_two">
                    Address line two
                </x-input.label>
                <x-input.text
                    id="line_two"
                    type="text"
                    wire:model.defer="address_line_two"
                />
                @error('address_line_two')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="suburb">
                    Suburb
                </x-input.label>
                <x-input.text
                    id="suburb"
                    type="text"
                    wire:model.defer="suburb"
                />
                @error('suburb')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="city">
                    City
                </x-input.label>
                <x-input.text
                    id="city"
                    type="text"
                    wire:model.defer="city"
                />
                @error('city')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="postal_code">
                    Postal code
                </x-input.label>
                <x-input.text
                    id="postal_code"
                    type="text"
                    wire:model.defer="postal_code"
                />
                @error('postal_code')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-2">
                <x-input.label for="country">
                    Country
                </x-input.label>
                <x-input.text
                    id="country"
                    type="text"
                    wire:model.defer="country"
                />
                @error('country')
                    <x-input.error>{{ $message }}</x-input.error>
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
