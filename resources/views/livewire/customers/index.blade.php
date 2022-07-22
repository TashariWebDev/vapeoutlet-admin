<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 px-2 md:px-0">
        <div class="md:col-span-2">
            <x-input-search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full">
            <div>
                <button class="button-success w-full"
                        x-on:click="@this.set('showCreateCustomerForm',true)"
                >
                    <x-icons.plus class="w-5 w-5 mr-2"/>
                    New customer
                </button>
            </div>
        </div>
    </div>

    <x-slide-over title="Create customers" wire:model.defer="showCreateCustomerForm">
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="name" label="name" required/>
                </div>
                <div class="py-2">
                    <x-input type="email" wire:model.defer="email" label="email" required/>
                </div>
                <div class="py-3">
                    <x-input type="text" wire:model.defer="phone" label="phone"/>
                </div>
                @hasPermissionTo('edit customers')
                <div class="py-2 bg-gray-100 rounded-md px-2">
                    <label for="is_wholesale" class="text-xs uppercase font-medium flex items-center space-x-2">
                        <input type="checkbox" wire:model.defer="is_wholesale" id="is_wholesale"
                               class="rounded-full text-green-500 focus:ring-gray-200"/>
                        <span class="ml-3">Wholesale</span>
                    </label>
                </div>
                @endhasPermissionTo
                <div class="py-3">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <div class="py-6">
        <div
            class="hidden lg:grid  lg:grid-cols-6 border text-sm bg-white rounded-t text-sm font-semibold uppercase py-2 bg-gradient-gray text-white">
            <div class="border-r px-2 col-span-2">name</div>
            <div class="border-r px-2">email</div>
            <div class="border-r px-2 ">phone</div>
            <div class="border-r px-2 text-center">wholesale</div>
            <div class="px-2 text-right">balance</div>
        </div>

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @forelse($customers as $customer)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 border text-sm bg-white md:py-1
                        @if($loop->last) rounded-b @endif">
                    <div class="border-r lg:py-2 lg:px-2 text-center lg:text-left col-span-2">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>name</p>
                        </div>
                        <div class="lg:block flex items-center text-center lg:text-left p-2">
                            <a href="{{ route('customers/show',$customer->id) }}"
                               class="link text-center lg:text-left">
                                {{ $customer->name }}
                                @if($customer->trashed())
                                    <span class="text-red-600 text-xs">( de-activated )</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="border-r lg:py-2 lg:px-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>email</p>
                        </div>
                        <p class="p-2">{{ $customer->email }}</p>
                    </div>
                    <div class="border-r lg:py-2 lg:px-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>phone</p>
                        </div>
                        <p class="p-2">{{ $customer->phone }}</p>
                    </div>
                    <div class="border-r lg:py-2 lg:px-2 text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>wholesale</p>
                        </div>
                        @if($customer->is_wholesale)
                            <div class="flex justify-center p-2">
                                <x-icons.tick class="w-5 h-5 text-green-600"/>
                            </div>
                        @else
                            <p></p>
                        @endif
                    </div>
                    <div class="lg:py-2 lg:px-2 lg:text-right text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>balance</p>
                        </div>
                        <p class="p-2">balance</p>
                    </div>
                </div>
            @empty
                <div class="py-6">
                    <div class="text-center py-10 bg-white rounded-md">
                        <x-icons.user class="mx-auto h-12 w-12 text-gray-400"/>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No customers</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new customer.</p>
                        <div class="mt-6">
                            <button type="button"
                                    class="button-success" x-on:click="@this.set('showCreateCustomerForm',true)">
                                <x-icons.plus
                                    class="-ml-1 mr-2 h-5 w-5 animate-pulse rounded-full ring ring-white ring-1"/>
                                New customer
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="py-6">
        {{ $customers->links() }}
    </div>
</div>
