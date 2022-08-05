<div class="grid grid-cols-1 lg:grid-cols-2 space-x-4">

    <div class="pr-4">
        <form wire:submit.prevent="updateUser">
            <div class="py-1">
                <label for="email-address" class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <input type="email" id="email-address" wire:model.defer="email"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'email')
                <div class="py-1">
                    <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="py-1">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" wire:model.defer="name"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'name')
                <div class="py-1">
                    <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="py-1">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" wire:model.defer="phone"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('phone')
                <div class="py-1">
                    <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="py-1">
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <input type="text" id="company" wire:model.defer="company"
                       class="block w-full border-gray-300 rounded-md shadow-sm m:text-sm"
                >
                @error('company')
                <div class="py-1">
                    <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="py-1">
                <label for="vat_number" class="block text-sm font-medium text-gray-700">Vat number</label>
                <input type="text" id="vat_number" wire:model.defer="vat_number"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('vat_number')
                <div class="py-1">
                    <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="pt-3">
                <button class="button-success">update</button>
            </div>
        </form>
    </div>

    <div class="pr-4">
        <form wire:submit.prevent="addAddress">
            <div class="py-1">
                <label for="address_line_one" class="block text-sm font-medium text-gray-700">
                    Address line one
                </label>
                <input type="text" id="address_line_one" wire:model.defer="line_one"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'line_one')
                <div class="py-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="address_line_two" class="block text-sm font-medium text-gray-700">
                    Address line two
                </label>
                <input type="text" id="address_line_two" wire:model.defer="line_two"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error( 'line_two')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="suburb" class="block text-sm font-medium text-gray-700">
                    Suburb
                </label>
                <input type="text" id="suburb" wire:model.defer="suburb"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('suburb')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="city" class="block text-sm font-medium text-gray-700">
                    City
                </label>
                <input type="text" id="city" wire:model.defer="city"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('city')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                <select id="province" name="province" wire:model.defer="province"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    <option value="">Select a province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" class="capitalize">
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <div class="py-1">
                <label for="postal_code" class="block text-sm font-medium text-gray-700">
                    Postal code
                </label>
                <input type="text" id="postal_code" wire:model.defer="postal_code"
                       class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                >
                @error('postal_code')
                <div class="pt-1">
                    <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="pt-3">
                <button class="button-success">
                    add address
                </button>
            </div>
        </form>
    </div>

</div>
