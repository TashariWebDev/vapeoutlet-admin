@props([
    'label'
])
<div
    class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-red-600 focus-within:border-red-600 bg-white">

    <label for="{{$attributes->only('id')->first()}}"
           class="absolute rounded border -top-2 left-2 -mt-1 inline-block px-1 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>

    <input id="{{$attributes->only('id')->first()}}" {{ $attributes }}
    class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm"
           wire:keydown.enter.prevent
    >

    @error($attributes->only('wire:model.defer')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
