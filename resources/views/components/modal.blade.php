<div
    class="relative z-40"
    role="dialog"
    aria-labelledby="modal-title"
    aria-modal="true"
    {{ $attributes }}
    x-show="show"
    x-cloak
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur"></div>

    <div class="overflow-y-auto fixed inset-0 z-10">
        <div
            class="flex justify-center items-end p-4 min-h-full text-center sm:items-center sm:p-0"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div
                class="overflow-hidden relative p-4 w-full text-left bg-white rounded-md shadow-sm transition-all transform sm:my-8 lg:max-w-3xl dark:bg-slate-950"
                x-on:click.outside="show = !show"
            >

                <div class="absolute top-0 right-0 m-4">
                    <button x-on:click="show = !show">
                        <x-icons.close class="w-8 h-8 text-rose-500 hover:text-rose-600" />
                    </button>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
