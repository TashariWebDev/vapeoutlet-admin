<div>
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-2 md:px-0">
        <div class="md:col-span-2">
            <x-input-search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full">
            <div>
                <a href="{{ route('inventory',['showPurchaseCreateForm']) }}" class="button-success w-full">
                    <x-icons.plus class="w-5 w-5 mr-2"/>
                    New supplier
                </a>
            </div>
        </div>
        <div></div>
        <div></div>
    </div>

    <div class="py-6">
        @if($suppliers->count())
            <div
                class="hidden lg:grid lg:grid-cols-6 border text-sm bg-white rounded-t text-sm font-semibold uppercase py-2 bg-gradient-gray text-white">
                <div class="border-r px-2">id</div>
                <div class="col-span-2 border-r px-2">name</div>
                <div class="border-r px-2">email</div>
                <div class="border-r px-2 ">phone</div>
                <div class="border-r px-2">contact</div>
                <div class="px-2 text-left"></div>
            </div>
        @endif

        <div class="grid grid-cols-1 py-2">
            @forelse($suppliers as $supplier)
                <div class="grid grid-cols-3 lg:grid-cols-6 border text-sm bg-white
        @if($loop->last) rounded-b @endif">
                    <div class="col-span-2 lg:col-span-2 border-r lg:px-2 lg:py-2 col-span-2">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>name</p>
                        </div>
                        <div class="lg:block flex items-center">
                            <a href="{{ route('suppliers/show',$supplier->id) }}" class="link">
                                {{ $supplier->name }}
                            </a>
                        </div>
                    </div>
                    <div class="border-r lg:px-2 lg:py-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>email</p>
                        </div>
                        <p class="p-2">{{ $supplier->email }}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:py-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>phone</p>
                        </div>
                        <p class="p-2">{{ $supplier->phone }}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:py-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>contact</p>
                        </div>
                        <p class="p-2">{{ $supplier->person }}</p>
                    </div>
                    <div class="border-r md:px-2 md:text-left text-center">
                        <div class="md:hidden bg-gradient-gray text-white">
                            <p></p>
                        </div>
                        <p></p>
                    </div>
                </div>
            @empty
                <div class="py-6">
                    <div class="text-center py-10 bg-white rounded-md">
                        <x-icons.users class="mx-auto h-12 w-12 text-gray-400"/>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No suppliers</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new supplier.</p>
                        <div class="mt-6">
                            <a href="{{ route('inventory',['showPurchaseCreateForm']) }}" type="button"
                               class="button-success">
                                <x-icons.plus
                                    class="-ml-1 mr-2 h-5 w-5 animate-pulse rounded-full ring ring-white ring-1"/>
                                New Supplier
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="py-6">
        {{ $suppliers->links() }}
    </div>
</div>
