@props([
    'label'
])
<div
    class="relative border border-gray-300 rounded-md px-3 py-2 focus:shadow-sm focus-within:ring-1 focus-within:ring-yellow-500 focus-within:border-yellow-500 bg-white">

    <label for="{{$attributes->only('id')->first()}}"
           class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>

    <input id="{{$attributes->only('id')->first()}}" {{ $attributes }}
    class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm"
           autocomplete="off"
           wire:keydown.enter.prevent
           step="0.01"
           inputmode="numeric"
           pattern="[0-9.]+"
    >
    @error($attributes->only('name')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
