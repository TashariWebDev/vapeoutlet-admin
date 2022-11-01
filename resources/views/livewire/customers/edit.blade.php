<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 lg:space-x-4">

        <div class="p-4">
            <form wire:submit.prevent="updateUser">
                <div class="py-1">
                    <label for="email-address"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        Email address
                    </label>
                    <input type="email"
                           id="email-address"
                           wire:model.defer="email"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error( 'email')
                    <div class="py-1">
                        <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="py-1">
                    <label for="name"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Name</label>
                    <input type="text"
                           id="name"
                           wire:model.defer="name"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error( 'name')
                    <div class="py-1">
                        <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="py-1">
                    <label for="phone"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Phone</label>
                    <input type="text"
                           id="phone"
                           wire:model.defer="phone"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error('phone')
                    <div class="py-1">
                        <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="py-1">
                    <label for="company"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Company</label>
                    <input type="text"
                           id="company"
                           wire:model.defer="company"
                           class="block w-full border-slate-300 rounded-md shadow-sm m:text-sm"
                    >
                    @error('company')
                    <div class="py-1">
                        <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="py-1">
                    <label for="vat_number"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Vat number</label>
                    <input type="text"
                           id="vat_number"
                           wire:model.defer="vat_number"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error('vat_number')
                    <div class="py-1">
                        <p class="uppercase text-red-600 text-xs">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                @hasPermissionTo('upgrade customers')
                <div class="py-1">
                    <label for="is_wholesale"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Is Wholesale Customer</label>
                    <select id="is_wholesale"
                            name="is_wholesale"
                            wire:model.defer="is_wholesale"
                            class="w-full border-slate-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                    >
                        <option value="">Choose</option>
                        <option value="0"
                                class="capitalize"
                        >
                            No
                        </option>
                        <option value="1"
                                class="capitalize"
                        >
                            Yes
                        </option>
                    </select>
                    @error('is_wholesale')
                    <div class="pt-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="py-1">
                    <label for="salesperson_id"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Salesperson</label>
                    <select id="salesperson_id"
                            name="salesperson_id"
                            wire:model.defer="salesperson_id"
                            class="w-full border-slate-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                    >
                        <option value="">Choose</option>
                        @foreach($salespeople as $salesperson)
                            <option value="{{$salesperson->id}}"
                                    class="capitalize"
                            >
                                <p class="capitalize">{{$salesperson->name}}</p>
                            </option>
                        @endforeach
                    </select>
                    @error('salesperson_id')
                    <div class="pt-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                @endhasPermissionTo

                <div class="pt-3">
                    <button class="button-success">update</button>
                </div>
            </form>
        </div>

        <div class="p-4">
            <form wire:submit.prevent="addAddress">
                <div class="py-1">
                    <label for="address_line_one"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        Address line one
                    </label>
                    <input type="text"
                           id="address_line_one"
                           wire:model.defer="line_one"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error( 'line_one')
                    <div class="py-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="py-1">
                    <label for="address_line_two"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        Address line two
                    </label>
                    <input type="text"
                           id="address_line_two"
                           wire:model.defer="line_two"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error( 'line_two')
                    <div class="pt-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="py-1">
                    <label for="suburb"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        Suburb
                    </label>
                    <input type="text"
                           id="suburb"
                           wire:model.defer="suburb"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error('suburb')
                    <div class="pt-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="py-1">
                    <label for="city"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        City
                    </label>
                    <input type="text"
                           id="city"
                           wire:model.defer="city"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                    >
                    @error('city')
                    <div class="pt-1">
                        <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="py-1">
                    <label for="province"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >Province</label>
                    <select id="province"
                            name="province"
                            wire:model.defer="province"
                            class="w-full border-slate-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                    >
                        <option value="">Select a province</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}"
                                    class="capitalize"
                            >
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
                    <label for="postal_code"
                           class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                    >
                        Postal code
                    </label>
                    <input type="text"
                           id="postal_code"
                           wire:model.defer="postal_code"
                           class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
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

        <div>
            <div>
                <p class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1">Addresses</p>
            </div>
            @foreach($customer->addresses as $address)
                <div class="bg-white px-2 py-3 rounded-md capitalize mb-2 flex justify-between items-center">
                    <p class="text-xs">{{ $address->line_one }} {{ $address->line_two }} {{ $address->suburb }} {{ $address->city }} {{ $address->province }} {{ $address->postal_code }}</p>

                    <button wire:click="editAddress({{ $address->id }})">
                        <x-icons.edit class="text-green-600 w-5 h-5"/>
                    </button>
                </div>
            @endforeach
            <x-modal wire:model.defer="updateAddressForm">
                <form wire:submit.prevent="updateAddress">
                    <div class="py-1">
                        <label for="address_line_one"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >
                            Address line one
                        </label>
                        <input type="text"
                               id="address_line_one"
                               wire:model.defer="line_one"
                               class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                        >
                        @error( 'line_one')
                        <div class="py-1">
                            <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <div class="py-1">
                        <label for="address_line_two"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >
                            Address line two
                        </label>
                        <input type="text"
                               id="address_line_two"
                               wire:model.defer="line_two"
                               class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                        >
                        @error( 'line_two')
                        <div class="pt-1">
                            <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <div class="py-1">
                        <label for="suburb"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >
                            Suburb
                        </label>
                        <input type="text"
                               id="suburb"
                               wire:model.defer="suburb"
                               class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                        >
                        @error('suburb')
                        <div class="pt-1">
                            <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <div class="py-1">
                        <label for="city"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >
                            City
                        </label>
                        <input type="text"
                               id="city"
                               wire:model.defer="city"
                               class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                        >
                        @error('city')
                        <div class="pt-1">
                            <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <div class="py-1">
                        <label for="province"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >Province</label>
                        <select id="province"
                                name="province"
                                wire:model.defer="province"
                                class="w-full border-slate-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                        >
                            <option value="">Select a province</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}"
                                        class="capitalize"
                                >
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
                        <label for="postal_code"
                               class="block text-xs font-medium text-slate-700 dark:text-slate-300 pb-1"
                        >
                            Postal code
                        </label>
                        <input type="text"
                               id="postal_code"
                               wire:model.defer="postal_code"
                               class="block w-full border-slate-300 rounded-md shadow-sm sm:text-sm"
                        >
                        @error('postal_code')
                        <div class="pt-1">
                            <p class="text-xs uppercase text-red-700">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="pt-3">
                        <button class="button-success">
                            update address
                        </button>
                    </div>
                </form>
            </x-modal>
        </div>


    </div>
</div>
