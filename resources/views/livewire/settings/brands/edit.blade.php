<div>
    <div class="py-2">
        {{ $brands->links() }}
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        @foreach($brands as $brand)
            <div
                class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex py-2 flex-wrap items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-1 min-w-0">
                    <label>
                        <input type="text" class="rounded-md border-gray-500" value="{{ $brand->name }}"
                               x-on:keydown.tab="@this.call('updateBrand',{{$brand->id}},$event.target.value)"
                        >
                    </label>
                    <div class="py-2 text-xs text-gray-500">
                        <p>{{ $brand->products_count }} products linked to this brand</p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="pb-3">
                        <img class="h-10 w-10 rounded-full" src="{{ $brand->image }}" alt="">
                    </div>
                    <div class="relative w-48 h-6 py-2 bg-gray-200 flex justify-center items-center">
                        <input type="file" wire:model="image"
                               class="text-xs border-transparent outline-0 bg-green-600 opacity-0 absolute z-20"
                               x-on:livewire-upload-finish="@this.call('updateImage',{{$brand->id}})"
                        >
                        <div class="w-full absolute z-10 px-3 text-xs">
                            <p>&uparrow; upload new image</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
