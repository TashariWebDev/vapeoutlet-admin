<button
    @click.prevent="showDropdown = !showDropdown"
    @refresh-dropdowns.window="showDropdown = false"
    class="block w-full py-2 rounded-md bg-gray-900 text-gray-300 border border-gray-700 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm text-left pl-3"
>
    {{ $slot }}
</button>
