<div {{ $attributes }} class="absolute inset-0 bg-gray-900 bg-opacity-90 z-50" wire:loading wire:target="process">
    <div class="w-full h-full flex justify-center items-center">
        <h1 class="text-white/75 text-7xl font-extrabold drop-shadow">WORKING ON IT!!</h1>
        <div class="absolute animate-spin-slow">
            <x-icons.spinner class="stroke-current w-20 h-20 animate-spin-slow animate-pulse"/>
            <x-icons.spinner class="w-20 h-20 animate-spin-slower"/>
            <x-icons.spinner class="w-20 h-20 animate-spin-slow animate-pulse"/>
        </div>
    </div>
</div>
