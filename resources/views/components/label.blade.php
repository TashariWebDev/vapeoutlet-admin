@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-500 dark:text-teal-400']) }}>
    {{ $value ?? $slot }}
</label>
