<div>

    <div>
        <a
            class="link"
            href="{{ route('settings') }}"
        >back to settings</a>
    </div>

    <x-slide-over
        title="Add marketing notification"
        wire:model.defer="showCreateNotificationForm"
    >
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-6">
                    <x-textarea
                        label="body"
                        wire:model.defer="body"
                    ></x-textarea>
                </div>
                <div>
                    <button class="button-success">
                        <x-icons.save class="mr-3 w-5 h-5" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <header class="flex justify-start py-6 lg:justify-end">
        <button
            class="button-success"
            x-on:click="@this.set('showCreateNotificationForm',true)"
        >
            <x-icons.plus class="mr-3 w-5 h-5" />
            add notification
        </button>
    </header>

    <section class="py-6">
        <div class="grid grid-cols-1 gap-y-2">
            @foreach ($notifications as $notification)
                <div class="grid grid-cols-2 gap-3 py-1 px-2 bg-white rounded-md lg:grid-cols-4">
                    <div class="col-span-3 py-6 text-slate-800">
                        <p>{{ $notification->body }}</p>
                    </div>
                    <div class="py-1 px-2 text-center">
                        <button
                            class="button-danger"
                            x-on:click="@this.call('delete',{{ $notification->id }})"
                        >
                            <x-icons.cross />
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
