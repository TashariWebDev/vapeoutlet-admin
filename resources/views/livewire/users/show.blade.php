<div>

    <div>
        <div class="flex justify-end items-center w-full px-2 md:px-0">
            @if(!$user->trashed())
                <div>
                    <button class="button-danger"
                            x-on:click="@this.call('deleteUser')"
                    >
                        <x-icons.cross class="text-white w-5 h-5 mr-2"/>
                        de-activate user
                    </button>
                </div>
            @else
                <div>
                    <button class="button-success"
                            x-on:click="@this.call('restoreUser')"
                    >
                        <x-icons.tick class="text-white w-5 h-5 mr-2"/>
                        activate user
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="md:py-12">
        <div class="pb-3">
            <h2 class="text-lg leading-6 font-bold text-slate-800 dark:text-slate-500">Update user</h2>
        </div>
        <div class="w-full p-4 bg-white dark:bg-slate-900 rounded-md">
            <form wire:submit.prevent="updateUser"
                  class="w-full md:w-1/2"
            >
                <div class="py-2">
                    <label for="name"
                           class="text-slate-500 text-xs mb-1"
                    >Name</label>
                    <div>
                        <input type="text"
                               id="name"
                               class="w-full rounded-md"
                               wire:model.defer="user.name"
                        />
                    </div>
                </div>
                <div class="py-2">
                    <label for="email"
                           class="text-slate-500 text-xs mb-1"
                    >Email</label>
                    <div>
                        <input type="email"
                               id="email"
                               class="w-full rounded-md"
                               wire:model.defer="user.email"
                        />
                    </div>
                </div>
                <div class="py-2">
                    <label for="phone"
                           class="text-slate-500 text-xs mb-1"
                    >Phone</label>
                    <div>
                        <input type="text"
                               id="phone"
                               class="w-full rounded-md"
                               wire:model.defer="user.phone"
                        />
                    </div>
                </div>
                <div class="py-2">
                    <button class="button-success">
                        update
                    </button>
                </div>
            </form>
        </div>
    </div>


    @if($user->permissions->count())
        <div class="pt-12 pb-6">
            <div class="flex flex-wrap justify-between items-center md:space-x-4 pb-3 px-2 md:px-0">
                <div>
                    <h2 class="text-lg leading-6 font-bold text-slate-800 dark:text-slate-500">User assigned
                                                                                               permissions</h2>
                </div>
                <div>
                    <button
                        class="w-64 button-danger"
                        x-on:click="@this.call('revokeAllPermissions')"
                    >
                        <x-icons.cross class="w-5 h-5 text-white mr-3"/>
                        Revoke all permissions
                    </button>
                </div>
            </div>
            <div
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-y-2 px-2 py-3 bg-white dark:bg-slate-900 rounded-md overflow-hidden"
            >
                @foreach($user->permissions as $permission)
                    <div>
                        <button
                            class="w-64 bg-white group hover:bg-red-600 hover:text-white px-2 py-1 uppercase inline-flex rounded-md text-sm font-semibold"
                            x-on:click="@this.call('revokePermission',{{$permission->id}})"
                        >
                            <x-icons.tick class="w-5 h-5 text-green-500 group-hover:text-white mr-3"/>
                            {{ $permission->name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($permissions->count() != 0)
        <div class="py-12">
            <div class="flex flex-wrap md:justify-between items-center pb-3 px-2 md:px-0">
                <div class="py-2">
                    <h2 class="font-bold text-2xl whitespace-nowrap">Available permissions</h2>
                </div>
                <div class="flex space-x-2">


                    <div>
                        <button
                            class="w-64 button-success"
                            x-on:click="@this.call('assignAllPermissions')"
                        >
                            <x-icons.tick class="w-5 h-5 text-white mr-3"/>
                            Assign all permissions
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-md">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-2 py-3 px-2">
                    @foreach($permissions as $permission)
                        <div>
                            <button
                                class="w-64 bg-white group hover:bg-green-600 hover:text-white px-2 py-1 uppercase inline-flex rounded-md text-sm font-semibold"
                                x-on:click="@this.call('addPermission',{{$permission->id}})"
                            >
                                <x-icons.plus class="w-5 h-5 text-green-500 group-hover:text-white mr-3"/>
                                {{ $permission->name }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
</div>
