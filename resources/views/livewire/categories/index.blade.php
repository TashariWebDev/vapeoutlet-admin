<div>
    <div>
        <p class="text-2xl font-bold text-slate-600 dark:text-slate-400">Categories</p>

        <a
            class="link"
            href="{{ route('settings') }}"
        >back to settings</a>
    </div>

    <div class="py-2">
        {{ $categories->links() }}
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
        @foreach ($categories as $category)
            <div class="p-2 rounded-md bg-slate-300 dark:bg-slate-900">
                <x-form.input.label for="name-{{ $category->id }}">
                    Name
                </x-form.input.label>
                <x-form.input.text
                    id="name-{{ $category->id }}"
                    type="text"
                    value="{{ $category->name }}"
                    wire:keyup.debounce.300ms="updateCategory({{ $category->id }},$event.target.value)"
                />
                <div class="py-2">
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        {{ $category->products_count }} products linked
                    </p>
                </div>
            </div>
        @endforeach
    </div>

</div>
