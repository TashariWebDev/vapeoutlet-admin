<div>
    <x-slide-over title="Upload banners" wire:model.defer="showCreateBannerForm">
        <div>
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-input label="banner image" type="file" wire:model.defer="image" id="upload{{$iteration}}"/>
                </div>
                <div class="py-2">
                    <button class="button-success w-full">
                        <x-icons.upload class="w-5 h-5 text-white mr-2"/>
                        upload
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <header class="flex justify-start lg:justify-end py-6">
        <button class="button-success"
                x-on:click="@this.set('showCreateBannerForm',true)"
        >
            <x-icons.plus class="w-5 h-5 mr-2"/>
            upload banner
        </button>
    </header>

    <section class="grid grid-cols-1">
        @foreach($banners as $banner)
            <div class="bg-white p-6 rounded-md">
                <div class="relative rounded-md">
                    <img src="{{ config('app.admin_url').'/storage/'.$banner->image }}" alt=""
                         class="w-full rounded-md object-cover">

                    <button class="button-danger absolute top-0 right-0"
                            x-on:click="@this.call('delete',{{$banner->id}})"
                    >
                        <x-icons.cross/>
                    </button>
                </div>
            </div>
        @endforeach
    </section>
    <div class="py-6">
        {{ $banners->links() }}
    </div>
</div>
