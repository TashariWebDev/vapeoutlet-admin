<div class="absolute w-full p-1 origin-top-right mt-2 bg-gray-800 border border-gray-700 rounded shadow z-50"
     x-show="showDropdown"
     x-transition
>
    <div class="grid grid-cols-1 gap-y-2">
        {{ $slot }}
    </div>
</div>
