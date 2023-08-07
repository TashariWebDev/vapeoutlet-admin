<div>
    
    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <x-page-header>
            Add notification
        </x-page-header>
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-6">
                    <x-input.label for="body">
                        Notification
                    </x-input.label>
                    <x-input.textarea
                        id="body"
                        wire:model.defer="body"
                    ></x-input.textarea>
                    @error('body')
                    <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div>
                    <button class="button-success">
                        <x-icons.busy target="save" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>
    
    <div class="py-3 bg-white rounded-md shadow-sm dark:bg-slate-900">
        <header class="flex justify-between items-center py-6 px-2">
            <x-page-header>
                Notification settings
            </x-page-header>
            <button
                class="button-success"
                wire:click="$toggle('slide')"
            >
                add notification
            </button>
        </header>
        
        <div class="py-3 px-2">
            {{ $notifications->links() }}
        </div>
    </div>
    
    <div class="mt-2 bg-white rounded-md">
        <x-table.container>
            <x-table.header class="hidden text-sm lg:grid lg:grid-cols-3">
                <x-table.heading class="col-span-2">Body</x-table.heading>
                <x-table.heading class="text-right">Action</x-table.heading>
            </x-table.header>
            @forelse ($notifications as $notification)
                <x-table.body>
                    <x-table.row class="col-span-2 text-sm">
                        <p>{{ $notification->body }}</p>
                    </x-table.row>
                    <x-table.row class="text-right">
                        <button
                            class="button-danger"
                            wire:click="delete('{{ $notification->id }}')"
                        >
                            delete
                        </button>
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
