<div
    class="relative py-2 px-3 w-full bg-white rounded-md border border-gray-300 lg:w-72 focus-within:border-yellow-500 focus-within:ring-1 focus-within:ring-yellow-500 focus:shadow-sm">

    <label
        class="flex absolute -top-1 -left-1 justify-center items-center w-4 h-4 text-xs font-medium text-gray-900 bg-yellow-500 rounded-full ring-1 ring-white"
        for="search"
    >
        <x-icons.search class="w-3 h-3 text-white" />
    </label>

    <input
        class="block p-0 w-full placeholder-gray-500 text-gray-900 border-0 sm:text-sm focus:ring-0"
        id="search"
        type="search"
        {{ $attributes }}
        wire:keydown.enter.prevent
        autocomplete="off"
        placeholder="start typing..."
        autofocus
    >

    @error($attributes->only('wire:model.defer')->first())
        <div class="py-1">
            <p class="text-xs text-pink-600 uppercase">{{ $message }}</p>
        </div>
    @enderror
</div>
