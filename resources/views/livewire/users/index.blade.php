<div>

    <x-slide-over x-data="{ show: $wire.entangle('showCreateUserForm') }">
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input.label for="name">
                        Full Name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        required
                    />
                    @error('name')
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
                        wire:model.defer="email"
                        required
                    />
                    @error('email')
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
                        wire:model.defer="phone"
                    />
                    @error('phone')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <button class="button-success">
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <div class="p-2 bg-white rounded-lg shadow dark:bg-slate-900">

        <x-page-header class="px-2">
            Users
        </x-page-header>
        <div class="grid grid-cols-1 gap-3 py-3 px-2 lg:grid-cols-3">
            <div>
                <x-input.label>
                    Search
                </x-input.label>
                <x-input.text
                    type="text"
                    wire:model="searchQuery"
                    placeholder="email or name"
                    autocomplete="off"
                    autofocus
                >
                </x-input.text>
                <x-input.helper>
                    Query Time {{ round($queryTime, 3) }} ms
                </x-input.helper>
            </div>

            <div>
                <x-input.label>
                    Filter users
                </x-input.label>
                <div
                    class="flex items-center mt-1 w-full bg-white rounded-md border divide-x shadow-sm border-slate-300 dark:divide-slate-600 dark:border-slate-700 dark:bg-slate-700"
                >
                    <button
                        @class([
                            'py-2 pl-3 w-1/2 text-xs text-left text-slate-600 dark:text-slate-300' =>
                                $withTrashed == true,
                            'py-2 pl-3 w-1/2 text-xs text-left text-blue-700 dark:text-blue-600 font-semibold' =>
                                $withTrashed == false,
                        ])
                        wire:click="$set('withTrashed',false)"
                    >
                        Active
                    </button>
                    <button
                        @class([
                            'py-2 pl-3 w-1/2 text-xs text-left text-slate-500  dark:text-slate-400' =>
                                $withTrashed == false,

                            'py-2 pl-3 w-1/2 text-xs text-left text-blue-700 dark:text-blue-600 font-semibold' =>
                                $withTrashed == true,
                        ])
                        wire:click="$set('withTrashed',true)"
                    >
                        Include Inactive
                    </button>
                </div>
            </div>

            <div>
                <x-input.label>
                    Create a new user
                </x-input.label>
                <button
                    class="mt-1 w-full button-success"
                    wire:click="$toggle('showCreateUserForm')"
                >
                    New user
                </button>
            </div>
        </div>

        <div class="p-2">
            {{ $users->links() }}
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-4">
                <x-table.heading>id</x-table.heading>
                <x-table.heading>name</x-table.heading>
                <x-table.heading>email</x-table.heading>
                <x-table.heading>phone</x-table.heading>
            </x-table.header>
            @forelse($users as $user)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                    <x-table.row>{{ $user->id }}</x-table.row>
                    <x-table.row>
                        <a
                            class="link"
                            href="{{ route('users/show', $user->id) }}"
                        >
                            {{ $user->name }}
                            @if ($user->trashed())
                                <span class="text-xs text-rose-600">( de-activated )</span>
                            @endif
                        </a>
                    </x-table.row>
                    <x-table.row>{{ $user->email }}</x-table.row>
                    <x-table.row>{{ $user->phone }}</x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse

        </x-table.container>
    </div>

</div>
