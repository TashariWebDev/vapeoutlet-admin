<div>
    <div class="py-4 px-2 bg-white rounded-lg shadow dark:bg-slate-800">

        <x-page-header class="px-2">
            Categories
        </x-page-header>

        <div class="py-4 px-2">
            {{ $categories->links() }}
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
            @foreach ($categories as $category)
                <div class="p-2 rounded-md bg-slate-200 dark:bg-slate-900">
                    <x-input.label for="name-{{ $category->id }}">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="name-{{ $category->id }}"
                        type="text"
                        value="{{ $category->name }}"
                        wire:keyup.debounce.300ms="updateCategory({{ $category->id }},$event.target.value)"
                    />
                    <div class="flex justify-between items-center py-2">
                        <p class="text-xs text-teal-500 dark:text-teal-400">
                            {{ $category->products_count }} products linked
                        </p>
                        @if ($category->products_count == 0)
                            <button
                                class="link-alt"
                                wire:click="delete('{{ $category->id }}')"
                            >delete
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
