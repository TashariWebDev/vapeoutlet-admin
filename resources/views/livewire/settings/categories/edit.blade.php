<div>
    <div class="py-2">
        {{ $categories->links() }}
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        @foreach($categories as $category)

            <div
                class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="py-4 min-w-0">
                    <label>
                        <input type="text" class="rounded-md border-gray-500" value="{{ $category->name }}"
                               x-on:keydown.tab="@this.call('updateCategory',{{$category->id}},$event.target.value)"
                        >
                    </label>
                </div>
                <div class="py-2 text-xs text-gray-500">
                    <p>{{ $category->products_count }} products linked to this category</p>
                </div>
            </div>
        @endforeach
    </div>

</div>
