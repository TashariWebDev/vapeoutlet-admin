@props(['title'])
<div
    class="relative z-50"
    role="dialog"
    aria-labelledby="modal-title"
    aria-modal="true"
    {{ $attributes }}
    x-cloak
    wire:key
    x-show="show"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-data="{ show: @entangle($attributes->whereStartsWith('wire:model.defer')->first()) }"
>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div
        class="overflow-y-auto fixed inset-0 z-50"
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="flex justify-center items-end p-4 min-h-full text-center sm:items-center sm:p-0">
            <div
                class="overflow-hidden relative px-4 pt-5 pb-4 mx-auto w-full max-w-2xl text-left bg-white rounded-lg shadow-xl transition-all transform sm:p-6 sm:my-8"
                x-on:click.outside="show = !show"
            >
                <div class="hidden absolute top-0 right-0 pt-4 pr-4 sm:block">
                    <button
                        class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                        type="button"
                        x-on:click="show = !show"
                    >
                        <span class="sr-only">Close</span>
                        <!-- Heroicon name: outline/x -->
                        <svg
                            class="w-6 h-6"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <div>
                    <h1 class="text-2xl font-bold">{{ $title ?? '' }}</h1>
                </div>
                <div>
                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>
</div>
