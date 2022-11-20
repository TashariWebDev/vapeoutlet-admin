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
                <x-form.input.label for="address_line_one">
                    Address line one
                </x-form.input.label>
                <x-form.input.text
                    id="address_line_one"
                    type="text"
                    wire:model.defer="address.line_one"
                />
                @error('address.line_one')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-form.input.label for="address_line_two">
                    Address line two
                </x-form.input.label>
                <x-form.input.text
                    id="address_line_two"
                    type="text"
                    wire:model.defer="address.line_two"
                />
                @error('address.line_two')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-form.input.label for="suburb">
                    Suburb
                </x-form.input.label>
                <x-form.input.text
                    id="suburb"
                    type="text"
                    wire:model.defer="address.suburb"
                />
                @error('address.suburb')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-form.input.label for="city">
                    City
                </x-form.input.label>
                <x-form.input.text
                    id="city"
                    type="text"
                    wire:model.defer="address.city"
                />
                @error('address.city')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-form.input.label for="province">
                    Province
                </x-form.input.label>

                <x-form.input.select
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
                </x-form.input.select>
                @error('address.province')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
                @enderror
            </div>

            <div class="py-1">
                <x-form.input.label for="postal_code">
                    Postal code
                </x-form.input.label>

                <x-form.input.text
                    id="postal_code"
                    type="text"
                    wire:model.defer="address.postal_code"
                />
                @error('address.postal_code')
                    <x-form.input.error>{{ $message }}</x-form.input.error>
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
