<div>
    <div class="p-2">
        <x-page-header>
            {{ $this->customer->name }}
        </x-page-header>
        <a
            class="link"
            href="{{ route('customers/show', $customer->id) }}"
        >Back to customer</a>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

        <div class="p-4 rounded-lg bg-white dark:bg-slate-800 shadow">
            <form wire:submit.prevent="save">
                <div class="py-1">
                    <x-form.input.label for="email-address">
                        Email address
                    </x-form.input.label>
                    <x-form.input.text
                        id="email-address"
                        type="email"
                        wire:model.defer="customer.email"
                    />
                    @error('customer.email')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-1">
                    <x-form.input.label for="name">
                        Full Name
                    </x-form.input.label>
                    <x-form.input.text
                        id="name"
                        type="text"
                        wire:model.defer="customer.name"
                    />
                    @error('customer.name')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-1">
                    <x-form.input.label for="phone">
                        Phone
                    </x-form.input.label>

                    <x-form.input.text
                        id="phone"
                        type="text"
                        wire:model.defer="customer.phone"
                    />
                    @error('customer.phone')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-1">
                    <x-form.input.label for="company">
                        Company
                    </x-form.input.label>
                    <x-form.input.text
                        id="company"
                        type="text"
                        wire:model.defer="customer.company"
                    />
                    @error('customer.company')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-1">
                    <x-form.input.label for="vat_number">
                        Vat number
                    </x-form.input.label>
                    <x-form.input.text
                        id="vat_number"
                        type="text"
                        wire:model.defer="customer.vat_number"
                    />
                    @error('customer.vat_number')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                @hasPermissionTo('upgrade customers')
                    <div class="py-1">
                        <x-form.input.label for="is_wholesale">
                            Is Wholesale Customer
                        </x-form.input.label>
                        <x-form.input.select
                            id="is_wholesale"
                            name="is_wholesale"
                            wire:model.defer="customer.is_wholesale"
                        >
                            <option value="">Choose</option>
                            <option
                                class="capitalize"
                                value="0"
                            >
                                No
                            </option>
                            <option
                                class="capitalize"
                                value="1"
                            >
                                Yes
                            </option>
                        </x-form.input.select>
                        @error('customer.is_wholesale')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                    <div class="py-1">
                        <x-form.input.label for="salesperson_id">
                            Salesperson
                        </x-form.input.label>
                        <x-form.input.select
                            id="salesperson_id"
                            name="salesperson_id"
                            wire:model.defer="customer.salesperson_id"
                        >
                            <option value="">Choose</option>
                            @foreach ($salespeople as $salesperson)
                                <option
                                    class="capitalize"
                                    value="{{ $salesperson->id }}"
                                >
                                    <p class="capitalize">{{ $salesperson->name }}</p>
                                </option>
                            @endforeach
                        </x-form.input.select>
                        @error('customer.salesperson_id')
                            <x-form.input.error>{{ $message }}</x-form.input.error>
                        @enderror
                    </div>
                @endhasPermissionTo

                <div class="pt-3">
                    <button class="button-success">update</button>
                </div>
            </form>
        </div>

        <div class="p-4 rounded-lg bg-white dark:bg-slate-800 shadow">
            <div class="flex justify-end">
                <livewire:address.create customer_id="{{ $this->customer->id }}" />
            </div>
            <div class="pb-2">
                <x-form.input.label>Addresses</x-form.input.label>
            </div>
            @foreach ($this->customer->addresses as $address)
                <div
                    class="flex justify-between items-center py-3 px-2 mb-2 capitalize text-slate-500 dark:text-slate-300 bg-slate-100 rounded-md dark:bg-slate-700">
                    <p class="text-xs">{{ $address->line_one }} {{ $address->line_two }} {{ $address->suburb }}
                        {{ $address->city }} {{ $address->province }} {{ $address->postal_code }}</p>

                    <div>
                        <livewire:address.edit
                            wire:key="address-{{ $address->id }}"
                            address-id="{{ $address->id }}"
                        />
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
