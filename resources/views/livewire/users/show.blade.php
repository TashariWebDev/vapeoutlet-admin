<div>

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

        <div class="p-2 w-full bg-white rounded-lg shadow lg:w-1/2 dark:bg-slate-800">
            <form
                class="w-full"
                wire:submit.prevent="updateUser"
            >
                <div class="py-2">
                    <x-form.input.label for="name">
                        Full name
                    </x-form.input.label>
                    <x-form.input.text
                        id="name"
                        type="text"
                        wire:model.defer="user.name"
                    />
                    @error('user.name')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-form.input.label for="email">
                        Email
                    </x-form.input.label>
                    <x-form.input.text
                        id="email"
                        type="email"
                        wire:model.defer="user.email"
                    />
                    @error('user.email')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-form.input.label for="phone">
                        Phone
                    </x-form.input.label>
                    <x-form.input.text
                        id="phone"
                        type="text"
                        wire:model.defer="user.phone"
                    />
                    @error('user.phone')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
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
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-800 dark:bg-slate-900">
                @foreach ($user->permissions as $permission)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white hover:bg-pink-600 group"
                            wire:click="revokePermission('{{ $permission->id }}')"
                        >
                            <x-icons.tick class="mr-3 w-5 h-5 text-teal-500 group-hover:text-white" />
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
                class="grid overflow-hidden grid-cols-2 gap-y-2 py-3 px-2 bg-white rounded-lg shadow md:grid-cols-3 lg:grid-cols-3 dark:bg-slate-800 dark:bg-slate-900">
                @foreach ($permissions as $permission)
                    <div>
                        <button
                            class="inline-flex py-1 px-2 w-64 text-sm font-semibold uppercase bg-white rounded-md hover:text-white hover:bg-teal-600 group"
                            wire:click="addPermission('{{ $permission->id }}')"
                        >
                            <x-icons.plus class="mr-3 w-5 h-5 text-teal-500 group-hover:text-white" />
                            {{ $permission->name }}
                        </button>
                    </div>
                @endforeach
            </div>
    @endif
</div>
</div>
