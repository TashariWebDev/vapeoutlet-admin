@props([
    'label'
])
<div
    class="relative border border-gray-300 rounded-md shadow-sm focus-within:ring-1 focus-within:ring-red-600 focus-within:border-red-600 bg-white"
    wire:ignore>

    <label for="{{$attributes->only('id')->first()}}"
           class="absolute -top-2 left-2 rounded border -mt-1 inline-block px-3 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>

    <input id="{{$attributes->only('id')->first()}}" {{ $attributes }}
    class="block w-full h-full border-0 px-3 py-2 rounded-md outline-0 text-gray-900 placeholder-gray-300 focus:ring-0 sm:text-sm"
           wire:keydown.enter.prevent
           placeholder="start typing..."
    >
</div>
