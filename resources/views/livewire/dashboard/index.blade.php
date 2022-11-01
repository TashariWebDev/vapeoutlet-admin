<div wire:poll.3000ms>
    <div>
        <h3 class="text-lg leading-6 font-bold text-slate-800 dark:text-slate-500">Orders</h3>

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900 dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.shopping-bag class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">
                        Received
                    </p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->received }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=received"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Received orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.clipboard class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">Processed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->processed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=processed"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Processed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.products class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">Packed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->packed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=packed"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Packed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.truck class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">
                        Shipped
                    </p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->shipped }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=shipped"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Shipped orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.tick class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">Completed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->completed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=completed"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Completed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white dark:bg-slate-900/70 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden dark:border border-slate-900">
                <dt>
                    <div class="absolute bg-green-500 dark:bg-slate-900 rounded-md p-3">
                        <x-icons.cross class="w-6 h-6 text-green-100 dark:text-slate-500 dark:text-slate-500"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-400 dark:text-slate-600 truncate">Cancelled</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-slate-900 dark:text-slate-400">
                        {{ $orders->cancelled }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-slate-100 dark:bg-slate-900 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=cancelled"
                               class="link"
                            >
                                View all<span
                                    class="sr-only"
                                > Cancelled orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>
        </dl>
    </div>


    <div class="border-2 border-yellow-500 w-full h-32 rounded-md mt-4 p-4">
        <p class="text-yellow-600">Dark mode (Just for you @aasif) is enabled in beta and is not 100% complete. </p>
        <p class="text-yellow-600">Please report any issues. </p>
        <p class="text-yellow-600">We will be updating the ordering and credits system over the next few days. </p>
    </div>


</div>
