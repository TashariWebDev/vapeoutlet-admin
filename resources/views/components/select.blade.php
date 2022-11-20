@props(['label'])
<div
    class="w-full rounded-md focus-within:border-yellow-500 focus-within:ring-1 focus-within:ring-yellow-500 focus:shadow-sm">
    <label
        class="inline-block absolute top-2 left-2 px-1 -mt-px text-xs font-medium text-gray-900 bg-white"
        for="{{ $attributes->only('id')->first() }}"
    >
        {{ $label ?? '' }}
    </label>

    <select
        class="w-full placeholder-gray-500 text-gray-900 rounded-md sm:text-sm focus-within:border-yellow-500 focus-within:ring-1 focus-within:ring-yellow-500 focus:ring-0 focus:shadow-sm"
        id="{{ $attributes->only('id')->first() }}"
        {{ $attributes }}
    >
        <option
            class="w-full"
            value=""
        >choose...
        </option>
        {{ $slot }}
    </select>

    @error($attributes->only('wire:model.defer')->first())
        <div class="py-1">
            <p class="text-xs text-pink-600 uppercase">{{ $message }}</p>
        </div>
    @enderror
</div>
