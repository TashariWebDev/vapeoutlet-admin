<div wire:poll.3000ms>
    <div>
        <h3 class="text-lg font-bold leading-6 text-slate-800 dark:text-slate-500">Orders</h3>

        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 lg:grid-cols-3">
            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.shopping-bag class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                        Received
                    </p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->received }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=received"
                            >
                                View all<span class="sr-only"> Received orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.clipboard class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Processed</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->processed }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=processed"
                            >
                                View all<span class="sr-only"> Processed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.products class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Packed</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->packed }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=packed"
                            >
                                View all<span class="sr-only"> Packed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.truck class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                        Shipped
                    </p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->shipped }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=shipped"
                            >
                                View all<span class="sr-only"> Shipped orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.tick class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Completed</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->completed }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=completed"
                            >
                                View all<span class="sr-only"> Completed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div
                class="overflow-hidden relative px-4 pt-5 pb-12 bg-white rounded-lg shadow sm:px-6 sm:pt-6 dark:border border-slate-900 dark:bg-slate-900/70">
                <dt>
                    <div class="absolute p-3 bg-green-500 rounded-md dark:bg-slate-900">
                        <x-icons.cross class="w-6 h-6 text-green-100 dark:text-slate-500" />
                    </div>
                    <p class="ml-16 text-sm font-medium text-slate-400 truncate dark:text-slate-400">Cancelled</p>
                </dt>
                <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->cancelled }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 py-4 px-4 sm:px-6 bg-slate-100 dark:bg-slate-900">
                        <div class="text-sm">
                            <a
                                class="link"
                                href="/orders?filter=cancelled"
                            >
                                View all<span class="sr-only"> Cancelled orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>
        </dl>
    </div>

</div>
