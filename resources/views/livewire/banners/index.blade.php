<div>

    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <div>
            <form wire:submit.prevent="save">
                <div class="py-2">
                    <x-form.input.label for="image">
                        Image
                    </x-form.input.label>
                    <x-form.input.text
                        id="upload{{ $iteration }}"
                        id="image"
                        type="file"
                        wire:model.defer="image"
                    />
                    @error('image')
                        <x-form.input.error>{{ $message }}</x-form.input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <button class="button-success">
                        <x-icons.upload
                            class="mr-2 w-5 h-5 text-white"
                            wire:loading.class="hidden"
                        />
                        <x-icons.busy target="save" />
                        upload
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <header class="flex justify-between items-center py-6 px-2">
            <x-page-header>
                Banners
            </x-page-header>
            <button
                class="button-success"
                wire:click="$toggle('slide')"
            >
                upload banner
            </button>
        </header>

        <div class="py-3 px-2">
            {{ $banners->links() }}
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-3">
                <x-table.heading>Image</x-table.heading>
                <x-table.heading>Order</x-table.heading>
                <x-table.heading class="text-right">Actions</x-table.heading>
            </x-table.header>
            @forelse ($banners as $banner)
                <x-table.body class="grid grid-cols-2 lg:grid-cols-3">
                    <x-table.row>
                        <img
                            class="object-cover w-full rounded-md"
                            src="{{ config('app.admin_url') . '/storage/' . $banner->image }}"
                            alt=""
                        >
                    </x-table.row>
                    <x-table.row>
                        <label>
                            <x-form.input.text
                                type="number"
                                value="{{ $banner->order }}"
                                inputmode="numeric"
                                pattern="[0-9]"
                                step="0.01"
                                @keydown.tab="$wire.call('updateOrder',{{ $banner->id }},$event.target.value)"
                            />
                        </label>
                    </x-table.row>
                    <x-table.row class="col-span-2 lg:col-span-1 lg:text-right">
                        <button
                            class="w-full lg:w-32 button-danger"
                            wire:click="delete('{{ $banner->id }}')"
                        >
                            <x-icons.busy target="delete" />
                            Delete
                        </button>
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
