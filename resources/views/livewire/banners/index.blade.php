<div>
    <div>
        <a
            class="link"
            href="{{ route('settings') }}"
        >back to settings</a>
    </div>

    <x-slide-over
        title="Upload banners"
        wire:model.defer="showCreateBannerForm"
    >
        <div>
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input
                        id="upload{{ $iteration }}"
                        type="file"
                        label="banner image"
                        wire:model.defer="image"
                    />
                </div>
                <div class="py-2">
                    <button class="w-full button-success">
                        <x-icons.upload class="mr-2 w-5 h-5 text-white" />
                        upload
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <header class="flex justify-start py-6 lg:justify-end">
        <button
            class="button-success"
            x-on:click="@this.set('showCreateBannerForm',true)"
        >
            <x-icons.plus class="mr-2 w-5 h-5" />
            upload banner
        </button>
    </header>

    <section class="grid grid-cols-1">
        @foreach ($banners as $banner)
            <div class="p-6 bg-white rounded-md">
                <div class="relative rounded-md">
                    <img
                        class="object-cover w-full rounded-md"
                        src="{{ config('app.admin_url') . '/storage/' . $banner->image }}"
                        alt=""
                    >

                    <div class="absolute right-0 bottom-0">
                        <label>
                            Display order
                            <input
                                type="number"
                                value="{{ $banner->order }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                @keydown.tab="@this.call('updateOrder',{{ $banner->id }},$event.target.value)"
                            />
                        </label>
                    </div>

                    <button
                        class="absolute top-0 right-0 button-danger"
                        x-on:click.prevent="@this.call('delete',{{ $banner->id }})"
                    >
                        <x-icons.cross />
                    </button>
                </div>
            </div>
        @endforeach
    </section>
    <div class="py-6">
        {{ $banners->links() }}
    </div>
</div>
