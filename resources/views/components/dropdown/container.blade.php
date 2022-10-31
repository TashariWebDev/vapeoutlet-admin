@props([
    'label'
])
<div class="w-full place-self-end"
     x-data="{showDropdown: false}"
     @refresh.window="showDropdown = false"
>
    <div class="mt-1 relative w-full block">
        {{ $slot }}
    </div>
</div>
