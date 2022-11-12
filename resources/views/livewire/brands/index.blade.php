<div>

    <div>
        <a
            class="link"
            href="{{ route('settings') }}"
        >back to settings</a>
    </div>

    <div class="py-2">
        {{ $brands->links() }}
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        @foreach ($brands as $brand)
            <div
                class="flex relative flex-wrap items-center py-2 py-5 px-6 space-x-3 bg-white rounded-lg border shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 border-slate-300 hover:border-slate-400">
                <div class="flex-1 min-w-0">
                    <label>
                        <input
                            class="rounded-md border-slate-500"
                            type="text"
                            value="{{ $brand->name }}"
                            x-on:keydown.tab="@this.call('updateBrand',{{ $brand->id }},$event.target.value)"
                        >
                    </label>
                    <div class="py-2 text-xs text-slate-500">
                        <p>{{ $brand->products_count }} products linked to this brand</p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="pb-3">
                        <img
                            class="w-10 h-10 bg-slate-100"
                            src="{{ $brand->image }}"
                            alt=""
                        >
                    </div>
                    <div class="flex relative justify-center items-center py-2 w-48 h-6 bg-slate-200">
                        <input
                            class="absolute z-10 text-xs bg-green-600 border-transparent opacity-0 outline-0"
                            type="file"
                            wire:model="image"
                            x-on:livewire-upload-finish="@this.call('updateImage',{{ $brand->id }})"
                        >
                        <div class="absolute z-0 px-3 w-full text-xs">
                            <p>&uparrow; upload new image</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
