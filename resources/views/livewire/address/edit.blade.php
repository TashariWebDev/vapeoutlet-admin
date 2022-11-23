<div>
    <button wire:click="$toggle('modal')">
        <x-icons.edit class="w-5 h-5 text-teal-600" />
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-500 dark:text-slate-400">Edit address</h3>
        </div>

        <form wire:submit.prevent="update">
            <div class="py-6">
                <x-input.label for="address_line_one">
                    Address line one
                </x-input.label>
                <x-input.text
                    id="address_line_one"
                    type="text"
                    wire:model.defer="address.line_one"
                />
                @error('address.line_one')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-input.label for="address_line_two">
                    Address line two
                </x-input.label>
                <x-input.text
                    id="address_line_two"
                    type="text"
                    wire:model.defer="address.line_two"
                />
                @error('address.line_two')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-input.label for="suburb">
                    Suburb
                </x-input.label>
                <x-input.text
                    id="suburb"
                    type="text"
                    wire:model.defer="address.suburb"
                />
                @error('address.suburb')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-input.label for="city">
                    City
                </x-input.label>
                <x-input.text
                    id="city"
                    type="text"
                    wire:model.defer="address.city"
                />
                @error('address.city')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-input.label for="province">
                    Province
                </x-input.label>

                <x-input.select
                    id="province"
                    name="province"
                    wire:model.defer="address.province"
                >
                    <option value="">Select a province</option>
                    @foreach ($provinces as $province)
                        <option
                            class="capitalize"
                            value="{{ $province }}"
                        >
                            {{ $province }}
                        </option>
                    @endforeach
                </x-input.select>
                @error('address.province')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-input.label for="postal_code">
                    Postal code
                </x-input.label>

                <x-input.text
                    id="postal_code"
                    type="text"
                    wire:model.defer="address.postal_code"
                />
                @error('address.postal_code')
                    <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="pt-3">
                <button class="button-success">
                    Update
                </button>
            </div>
        </form>
    </x-modal>
</div>
