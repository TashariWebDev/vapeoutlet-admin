<div>

    <button
        class="w-full button-success"
        wire:click="$toggle('modal')"
    >New address
    </button>

    <x-modal x-data="{ show: $wire.entangle('modal') }">
        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New address</h3>
        </div>

        <form wire:submit.prevent="save">
            <div class="py-6">
                <x-input.label for="address_line_one">
                    Address line one
                </x-input.label>
                <x-input.text
                    id="address_line_one"
                    type="text"
                    wire:model.defer="line_one"
                />
                @error('line_one')
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
                    wire:model.defer="line_two"
                />
                @error('line_two')
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
                    wire:model.defer="suburb"
                />
                @error('suburb')
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
                    wire:model.defer="city"
                />
                @error('city')
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
                    wire:model.defer="province"
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
                @error('province')
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
                    wire:model.defer="postal_code"
                />
                @error('postal_code')
                <x-input.error>{{ $message }}</x-input.error>
                @enderror
            </div>
            <div class="pt-3">
                <button class="button-success">
                    Save
                </button>
            </div>
        </form>
    </x-modal>
</div>
