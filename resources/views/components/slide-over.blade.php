<div
    class="relative z-40"
    role="dialog"
    aria-labelledby="slide-over-title"
    aria-modal="true"
    {{ $attributes }}
    x-show="show"
    x-cloak
>
    {{-- overlay --}}
    <div
        class="fixed inset-0 z-50 bg-opacity-75 transition-opacity backdrop-blur bg-slate-800"
        x-show="show"
        x-transition:enter="ease-in duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <div
        class="overflow-hidden fixed inset-0 z-50"
        x-show="show"
        x-transition:enter="transform transition ease-in duration-300 sm:duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300 sm:duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        <div class="overflow-hidden absolute inset-0">
            <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none">
                <div class="relative w-screen max-w-2xl pointer-events-auto">
                    <div
                        class="flex absolute top-0 left-0 pt-4 pr-2 -ml-8 sm:pr-4 sm:-ml-10"
                        x-show="show"
                        x-transition:enter="ease-in-out duration-100"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <button
                            class="rounded-md hover:text-white focus:ring-2 focus:ring-white focus:outline-none text-slate-300"
                            type="button"
                            x-on:click="show = false"
                        >
                            <span class="sr-only">Close panel</span>
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

                    <div class="flex overflow-y-scroll flex-col py-6 px-2 h-full bg-white shadow-sm dark:bg-slate-950">
                        <div class="relative flex-1 py-2 px-2 mt-3 bg-white rounded-md dark:bg-slate-950">
                            <!-- Replace with your content -->
                            {{ $slot }}
                            <!-- /End replace -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
