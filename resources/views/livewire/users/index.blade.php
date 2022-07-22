<div>
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-2 md:px-0">
        <div class="md:col-span-2">
            <x-input-search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full">
            <div>
                <button class="button-success w-full"
                        x-on:click="@this.set('showCreateUserForm',true)"
                >
                    <x-icons.plus class="w-5 w-5 mr-2"/>
                    New user
                </button>
            </div>
        </div>
    </div>

    <x-slide-over title="Create users" wire:model.defer="showCreateUserForm">
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="name" label="name" required/>
                </div>
                <div class="py-2">
                    <x-input type="email" wire:model.defer="email" label="email" required/>
                </div>
                <div class="py-2">
                    <x-input type="text" wire:model.defer="phone" label="phone"/>
                </div>
                <div class="py-2">
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
            class="hidden lg:grid lg:grid-cols-4 border text-sm bg-white rounded-t text-sm font-semibold uppercase py-2 bg-gradient-gray text-white">
            <div class="border-r px-2">id</div>
            <div class="border-r px-2">name</div>
            <div class="border-r px-2">email</div>
            <div class="px-2 ">phone</div>
        </div>

        <div class="grid grid-cols-1 gap-y-2 py-2">
            @forelse($users as $user)
                <div class="grid grid-cols-2 lg:grid-cols-4 border text-sm bg-white
                        @if($loop->last) rounded-b @endif">
                    <div class="border-r lg:px-2 lg:py-2 md:py-0 text-center lg:text-left">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>id</p>
                        </div>
                        <p class="text-xs p-2">{{ $user->id }}</p>
                    </div>
                    <div class="border-r lg:px-2 lg:py-2 md:py-0 text-center lg:text-left">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>name</p>
                        </div>
                        <div class="lg:block flex items-center p-2">
                            <a href="{{ route('users/show',$user->id) }}"
                               class="link">
                                {{ $user->name }}
                                @if($user->trashed())
                                    <span class="text-red-600 text-xs">( de-activated )</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="border-r lg:px-2 lg:py-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>email</p>
                        </div>
                        <p class="p-2">{{ $user->email }}</p>
                    </div>
                    <div class="lg:px-2 lg:py-2 lg:text-left text-center">
                        <div class="lg:hidden bg-gradient-gray text-white p-2">
                            <p>phone</p>
                        </div>
                        <p class="p-2">{{ $user->phone }}</p>
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
        {{ $users->links() }}
    </div>
</div>
