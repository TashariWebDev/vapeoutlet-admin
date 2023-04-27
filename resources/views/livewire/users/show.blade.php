<div>

    <div class="py-10">
        <div class="flex justify-end items-center px-2 w-full md:px-0">
            <div>
                <button
                    class="button-success"
                    wire:click="sendPasswordResetLink"
                >
                    Send password reset link
                </button>
            </div>
        </div>
    </div>

    <div>
        <div class="flex justify-end items-center px-2 w-full md:px-0">
            @if (!$user->trashed())
                <div>
                    <button
                        class="button-danger"
                        wire:click="deleteUser"
                    >
                        de-activate user
                    </button>
                </div>
            @else
                <div>
                    <button
                        class="button-success"
                        wire:click="restoreUser"
                    >
                        activate user
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div>
        <x-page-header class="pb-2">
            User details
        </x-page-header>

        <div class="p-2 w-full bg-white rounded-lg shadow lg:w-1/2 dark:bg-slate-900">
            <form
                class="w-full"
                wire:submit.prevent="updateUser"
            >
                <div class="py-2">
                    <x-input.label for="name">
                        Full name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="user.name"
                    />
                    @error('user.name')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-input.label for="email">
                        Email
                    </x-input.label>
                    <x-input.text
                        id="email"
                        type="email"
                        wire:model.defer="user.email"
                    />
                    @error('user.email')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-input.label for="phone">
                        Phone
                    </x-input.label>
                    <x-input.text
                        id="phone"
                        type="text"
                        wire:model.defer="user.phone"
                    />
                    @error('user.phone')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <button class="button-success">
                        update
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($user->permissions->count())
        <div class="pt-12 pb-6">
            <div class="flex justify-end py-3">
                <button
                    class="w-64 button-danger"
                    wire:click="revokeAllPermissions"
                >
                    Revoke all permissions
                </button>
            </div>
            <x-page-header class="pb-2">
                User permissions
            </x-page-header>

            <div
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-900"
            >
                @foreach ($user->permissions as $permission)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white hover:bg-rose-600 group"
                            wire:click="revokePermission('{{ $permission->id }}')"
                        >
                            <x-icons.tick class="mr-3 w-5 h-5 group-hover:text-white text-sky-500" />
                            {{ $permission->name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($permissions->count() != 0)
        <div class="py-12">
            <div class="flex justify-end py-3">
                <button
                    class="w-64 button-success"
                    wire:click="assignAllPermissions"
                >
                    Assign all permissions
                </button>
            </div>
            <x-page-header class="pb-2">
                Available permissions
            </x-page-header>

            <div
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-900"
            >
                @foreach ($permissions as $permission)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white group hover:bg-sky-600"
                            wire:click="addPermission('{{ $permission->id }}')"
                        >
                            <x-icons.plus class="mr-3 w-5 h-5 group-hover:text-white text-sky-500" />
                            {{ $permission->name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{--    Sales Channels --}}

    @if ($user->sales_channels->count())
        <div class="pt-12 pb-6">
            <x-page-header class="pb-2">
                User Sales Channels
            </x-page-header>

            <div
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-900"
            >
                @foreach ($user->sales_channels as $channel)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white hover:bg-rose-600 group"
                            wire:click="revokeSalesChannel('{{ $channel->id }}')"
                        >
                            <x-icons.tick class="mr-3 w-5 h-5 group-hover:text-white text-sky-500" />
                            {{ $channel->name }}
                        </button>

                        @if (!$channel->pivot->is_default)
                            <button
                                class="px-2 text-slate-500"
                                wire:click="setDefaultChannel('{{ $channel->id }}')"
                            >
                                make default
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($salesChannels->count() != 0)
        <div class="py-12">
            <x-page-header class="pb-2">
                Available Sales Channels
            </x-page-header>

            <div
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-900"
            >
                @foreach ($salesChannels as $chanel)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white group hover:bg-sky-600"
                            wire:click="addSalesChannel('{{ $chanel->id }}')"
                        >
                            <x-icons.plus class="mr-3 w-5 h-5 group-hover:text-white text-sky-500" />
                            {{ $chanel->name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
