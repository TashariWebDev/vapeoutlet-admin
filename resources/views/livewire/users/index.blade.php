<div>

    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
        <div>
            <x-form.input.label>
                Search
            </x-form.input.label>
            <x-form.input.text
                type="text"
                wire:model="searchQuery"
                placeholder="email or name"
            >
            </x-form.input.text>
        </div>

        <div>
            <x-form.input.label>
                Filter users
            </x-form.input.label>
            <div
                class="flex items-center py-2 mt-1 w-full bg-white rounded-md border divide-x shadow-sm border-slate-300 dark:divide-slate-600 dark:border-slate-700 dark:bg-slate-700">
                <button
                    @class([
                        'py-0.5 pl-3 w-1/2 text-sm text-left text-slate-500 dark:text-slate-400' =>
                            $withTrashed == true,
                        'py-0.5 pl-3 w-1/2 text-sm text-left text-green-700 dark:text-green-600 font-semibold' =>
                            $withTrashed == false,
                    ])
                    wire:click="$set('withTrashed',false)"
                >
                    Active
                </button>
                <button
                    @class([
                        'py-0.5 pl-3 w-1/2 text-sm text-left text-slate-500  dark:text-slate-400' =>
                            $withTrashed == false,

                        'py-0.5 pl-3 w-1/2 text-sm text-left text-green-700 dark:text-green-600 font-semibold' =>
                            $withTrashed == true,
                    ])
                    wire:click="$set('withTrashed',true)"
                >
                    Include Inactive
                </button>
            </div>
        </div>

        <div>
            <x-form.input.label>
                Create a new user
            </x-form.input.label>
            <button
                class="mt-1 w-full button-success"
                x-on:click="@this.set('showCreateUserForm',true)"
            >
                <x-icons.plus class="mr-2 w-5" />
                New user
            </button>
        </div>
    </div>

    <x-slide-over
        title="Create users"
        wire:model.defer="showCreateUserForm"
    >
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="name"
                        label="name"
                        required
                    />
                </div>
                <div class="py-2">
                    <x-input
                        type="email"
                        wire:model.defer="email"
                        label="email"
                        required
                    />
                </div>
                <div class="py-2">
                    <x-input
                        type="text"
                        wire:model.defer="phone"
                        label="phone"
                    />
                </div>
                <div class="py-2">
                    <button class="button-success">
                        <x-icons.save class="mr-2 w-5 h-5" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <div class="p-4">
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
                            <span class="text-xs text-red-600">( de-activated )</span>
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

    <div class="p-4">
        {{ $users->links() }}
    </div>
</div>
