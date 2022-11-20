@props(['label'])
<div
    class="relative py-2 px-3 bg-white rounded-md border border-gray-300 focus-within:border-yellow-500 focus-within:ring-1 focus-within:ring-yellow-500 focus:shadow-sm">

    <label
        class="inline-block absolute left-2 -top-2 px-1 -mt-px text-xs font-medium text-gray-900 bg-white"
        for="{{ $attributes->only('id')->first() }}"
    >
        {{ $label ?? '' }}
    </label>

    <input
        class="block p-0 w-full placeholder-gray-500 text-gray-900 border-0 sm:text-sm focus:ring-0"
        id="{{ $attributes->only('id')->first() }}"
        type="search"
        wire:keydown.enter.prevent
        autocomplete="off"
        placeholder="start typing..."
    >

    @error($attributes->only('wire:model.defer')->first())
        <div class="py-1">
            <p class="text-xs text-pink-600 uppercase">{{ $message }}</p>
        </div>
    @enderror
</div>
