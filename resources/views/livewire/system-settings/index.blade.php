<div>
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Company Information</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        This info will be displayed on all documents and emails.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div
                >
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="py-5 px-4 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="company_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >Company name</label>
                                    <input type="text"
                                           wire:model="company_name"
                                           id="company_name"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="company_registration_number"
                                           class="block text-sm font-medium text-gray-700"
                                    >Company Registration Number</label>
                                    <input type="text"
                                           wire:model="company_registration_number"
                                           id="company_registration_number"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="vat_registration_number"
                                           class="block text-sm font-medium text-gray-700"
                                    >Vat Registration Number</label>
                                    <input type="text"
                                           wire:model="vat_registration_number"
                                           id="vat_registration_number"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 my-16 sm:col-span-3">

                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email_address"
                                           class="block text-sm font-medium text-gray-700"
                                    >Email Address</label>
                                    <input type="email"
                                           wire:model="vat_registration_number"
                                           id="vat_registration_number"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone"
                                           class="block text-sm font-medium text-gray-700"
                                    >Phone number</label>
                                    <input type="text"
                                           wire:model="phone"
                                           id="phone"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 mb-16 sm:col-span-3">

                                </div>

                                <div class="col-span-6">
                                    <label for="address_line_one"
                                           class="block text-sm font-medium text-gray-700"
                                    >Street address</label>
                                    <input type="text"
                                           wire:model="address_line_one"
                                           id="address_line_one"
                                           autocomplete="address_line_one"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6">
                                    <label for="address_line_two"
                                           class="block text-sm font-medium text-gray-700"
                                    >Street address (line two)</label>
                                    <input type="text"
                                           wire:model="address_line_two"
                                           id="address_line_two"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="suburb"
                                           class="block text-sm font-medium text-gray-700"
                                    >Suburb</label>
                                    <input type="text"
                                           wire:model="suburb"
                                           id="suburb"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="city"
                                           class="block text-sm font-medium text-gray-700"
                                    >City</label>
                                    <input type="text"
                                           wire:model="city"
                                           id="city"
                                           autocomplete="address-level2"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>


                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="province"
                                           class="block text-sm font-medium text-gray-700"
                                    >Province</label>
                                    <input type="text"
                                           wire:model="province"
                                           id="province"
                                           autocomplete="address-level1"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="postal_code"
                                           class="block text-sm font-medium text-gray-700"
                                    >Postal code</label>
                                    <input type="text"
                                           wire:model="postal_code"
                                           id="postal_code"
                                           autocomplete="postal_code"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="country"
                                           class="block text-sm font-medium text-gray-700"
                                    >Country</label>
                                    <input type="text"
                                           wire:model="country"
                                           id="country"
                                           autocomplete="country"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 mb-16">

                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="bank_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >Bank name</label>
                                    <input type="text"
                                           wire:model="bank_name"
                                           id="bank_name"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="bank_branch"
                                           class="block text-sm font-medium text-gray-700"
                                    >Bank branch</label>
                                    <input type="text"
                                           wire:model="bank_branch"
                                           id="bank_branch"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="bank_branch_no"
                                           class="block text-sm font-medium text-gray-700"
                                    >Bank branch code/number</label>
                                    <input type="text"
                                           wire:model="bank_branch_no"
                                           id="bank_branch_no"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="bank_account_no"
                                           class="block text-sm font-medium text-gray-700"
                                    >Bank account number</label>
                                    <input type="text"
                                           wire:model="bank_account_no"
                                           id="bank_account_no"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>


                                <div class="col-span-6 mb-16">

                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="logo"
                                           class="block text-sm font-medium text-gray-700"
                                    >Logo (square | .png)</label>
                                    <input type="file"
                                           wire:model="logo"
                                           id="logo"
                                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    @if($this->company->logo)
                                        <div class="w-20 h-20">
                                            <img src="{{ asset('storage/'.$this->company->logo) }}"
                                                 alt="no logo available"
                                            >
                                        </div>
                                        <button wire:click="deleteLogo"
                                                class="text-red-600"
                                        >remove
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
