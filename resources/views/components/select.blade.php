@props([
    'label'
])
<div
    class="relative border rounded-md px-2 py-2 w-full">
    <label for="{{$label}}"
           class="absolute -top-2 left-1 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">
        {{ $label ?? '' }}
    </label>
    <select id="{{$label}}" {{ $attributes }}
    class="block w-full rounded-md border-none outline-0 py-1 outline-0 focus:outline-none focus:border-transparent text-gray-900 placeholder-gray-500 ring-gray-500 sm:text-sm"
    >
        <option value="">choose...</option>
        {{ $slot }}
    </select>
    @error($attributes->only('wire:model.defer')->first())
    <div class="py-1">
        <p class="text-xs uppercase text-red-600">{{ $message }}</p>
    </div>
    @enderror
</div>
