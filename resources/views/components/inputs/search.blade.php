<div
    class="relative border border-gray-300 rounded-md px-3 py-2 focus:shadow-sm focus-within:ring-1 focus-within:ring-yellow-500 focus-within:border-yellow-500 bg-white w-full lg:w-72">

    <label for="search"
           class="absolute -top-1 -left-1 rounded-full h-4 w-4 flex justify-center items-center bg-yellow-500 ring-1 ring-white text-xs font-medium text-gray-900">
        <x-icons.search class="w-3 h-3 text-white"/>
    </label>

    <input id="search" {{ $attributes }}
    class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm"
           type="search"
           wire:keydown.enter.prevent
           autocomplete="off"
           placeholder="start typing..."
           autofocus
    >

    @error($attributes->only('wire:model.defer')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
