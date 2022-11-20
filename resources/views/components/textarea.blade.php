@props(['label'])
<div
    class="relative py-2 px-3 rounded-md border border-gray-300 shadow-sm focus-within:border-pink-600 focus-within:ring-1 focus-within:ring-pink-600">
    <label
        class="inline-block absolute left-2 -top-2 px-1 -mt-px text-xs font-medium text-gray-900 bg-white"
        for="{{ $label }}"
    >
        {{ $label ?? '' }}
    </label>
    <textarea
        class="block p-0 w-full placeholder-gray-500 text-gray-900 border-0 sm:text-sm focus:ring-0"
        id="{{ $label }}"
        {{ $attributes }}
        cols="30"
        rows="10"
    ></textarea>

    @error($attributes->only('wire:model.defer')->first())
        <div class="py-1">
            <p class="text-xs text-pink-600 uppercase">{{ $message }}</p>
        </div>
    @enderror
</div>
