@props([
    'label'
])
<div {{ $attributes }}
     class="w-full rounded-md focus:shadow-sm focus-within:ring-1 focus-within:ring-yellow-500 focus-within:border-yellow-500">
    <label for="{{$attributes->only('id')->first()}}"
           class="absolute top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>

    <select id="{{$attributes->only('id')->first()}}"
            class="w-full rounded-md focus:shadow-sm focus-within:ring-1 focus-within:ring-yellow-500 focus-within:border-yellow-500
            text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
        <option value="" class="w-full">choose...</option>
        {{ $slot }}
    </select>

    @error($attributes->only('wire:model.defer')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
