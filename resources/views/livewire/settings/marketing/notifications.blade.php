<div>
    <x-slide-over title="Add marketing notification"
                  wire:model.defer="showCreateNotificationForm"
    >
        <div class="py-6">
            <form wire:submit.prevent="save">
                <div class="py-6">
                    <x-textarea label="body"
                                wire:model.defer="body"
                    ></x-textarea>
                </div>
                <div>
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-3"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <header class="flex justify-start lg:justify-end py-6">
        <button class="button-success"
                x-on:click="@this.set('showCreateNotificationForm',true)"
        >
            <x-icons.plus class="w-5 h-5 mr-3"/>
            add notification
        </button>
    </header>

    <section class="py-6">
        <div class="grid grid-cols-1 gap-y-2">
            @foreach($notifications as $notification)
                <div class="px-2 py-1 grid grid-cols-2 lg:grid-cols-4 gap-3 bg-white rounded-md">
                    <div class="col-span-3 text-gray-800 py-6">
                        <p>{{ $notification->body }}</p>
                    </div>
                    <div class="px-2 py-1 text-center">
                        <button class="button-danger"
                                x-on:click="@this.call('delete',{{$notification->id}})"
                        >
                            <x-icons.cross/>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
