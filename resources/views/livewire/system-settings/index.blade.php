<div>
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-slate-300">
                        Company Information</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        This info will be displayed on all documents and emails.
                    </p>
                </div>

                <div class="py-6">
                    @if($isInMaintenance)
                        <div>
                            <button class="button-warning"
                                    wire:click="enableFrontend"
                            >Turn on frontend
                            </button>

                            <div class="py-2">
                                <p class="text-red-600">Frontend is currently offline.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <button class="button-danger"
                                    wire:click="disableFrontend"
                            >Turn off frontend
                            </button>

                            <div class="py-2">
                                <p class="text-green-600">Frontend is currently online.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div
                >
                    <div class="overflow-hidden shadow-sm sm:rounded-md">
                        <div class="py-5 px-4 bg-white sm:p-6 dark:bg-slate-900">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.label for="company_name"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Company name
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="company_name"
                                                  id="company_name"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.label for="company_registration_number"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Company Registration Number
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="company_registration_number"
                                                  id="company_registration_number"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.label for="vat_registration_number"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Vat Registration Number
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="vat_registration_number"
                                                  id="vat_registration_number"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 my-8 sm:col-span-3">

                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.label for="email_address"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Email Address
                                    </x-input.label>
                                    <x-input.text type="email"
                                                  wire:model="email_address"
                                                  id="email_address"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.label for="phone"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Phone number
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="phone"
                                                  id="phone"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 mb-8 sm:col-span-3">

                                </div>

                                <div class="col-span-6">
                                    <x-input.label for="address_line_one"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Street address
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="address_line_one"
                                                  id="address_line_one"
                                                  autocomplete="address_line_one"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6">
                                    <x-input.label for="address_line_two"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Street address (line two)
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="address_line_two"
                                                  id="address_line_two"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="suburb"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Suburb
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="suburb"
                                                  autocomplete="address-level2"
                                                  id="suburb"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="city"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >City
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="city"
                                                  id="city"
                                                  autocomplete="address-level2"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>


                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <x-input.label for="province"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Province
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="province"
                                                  id="province"
                                                  autocomplete="address-level1"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <x-input.label for="postal_code"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Postal code
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="postal_code"
                                                  id="postal_code"
                                                  autocomplete="postal_code"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <x-input.label for="country"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Country
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="country"
                                                  id="country"
                                                  autocomplete="country"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 mb-8">

                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="bank_name"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Bank name
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="bank_name"
                                                  id="bank_name"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="bank_account_name"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Bank account name
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="bank_account_name"
                                                  id="bank_account_name"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>


                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="bank_branch"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Bank branch
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="bank_branch"
                                                  id="bank_branch"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="bank_branch_no"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Bank branch code/number
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="bank_branch_no"
                                                  id="bank_branch_no"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="bank_account_no"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Bank account number
                                    </x-input.label>
                                    <x-input.text type="text"
                                                  wire:model="bank_account_no"
                                                  id="bank_account_no"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>


                                <div class="col-span-6 mb-16">

                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <x-input.label for="logo"
                                                   class="block text-xs font-medium text-gray-700 dark:text-slate-400"
                                    >Logo (square | .png)
                                    </x-input.label>
                                    <x-input.text type="file"
                                                  wire:model="logo"
                                                  id="logo"
                                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    @if($this->company->logo)
                                        <div class="w-20 h-20">
                                            <img src="{{ asset('storage/'.$this->company->logo) }}"
                                                 alt="no logo available"
                                            >
                                        </div>
                                        <button wire:click="deleteLogo"
                                                class="text-rose-600"
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
