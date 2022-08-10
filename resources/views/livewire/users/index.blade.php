<div>

    <div class="flex flex-wrap space-y-2 lg:space-y-0 items-center lg:justify-between p-4">
        <div class="w-full lg:w-72">
            <x-inputs.search id="search" wire:model="searchQuery" label="Search"/>
        </div>

        <div class="w-full lg:w-72">
            <button class="button-success w-full"
                    x-on:click="@this.set('showCreateUserForm',true)"
            >
                <x-icons.plus class="w-5 w-5 mr-2"/>
                New user
            </button>
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
                    <a href="{{ route('users/show',$user->id) }}"
                       class="link">
                        {{ $user->name }}
                        @if($user->trashed())
                            <span class="text-red-600 text-xs">( de-activated )</span>
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
