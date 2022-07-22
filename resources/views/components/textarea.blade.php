@props([
    'label'
])
<div
    class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-red-600 focus-within:border-red-600">
    <label for="{{$label}}"
           class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>
    <textarea id="{{$label}}" {{ $attributes }}  cols="30" rows="10"
              class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm"
    ></textarea>

    @error($attributes->only('wire:model.defer')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
