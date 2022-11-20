<div wire:poll.3000ms>

    <div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.shopping-bag class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Received
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $lifetime_orders->received }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=received"
                        >
                            View all<span class="sr-only"> Received orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.clipboard class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Processed
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $lifetime_orders->processed }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=processed"
                        >
                            View all<span class="sr-only"> Processed orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.products class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Packed
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $lifetime_orders->packed }}
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=packed"
                        >
                            View all<span class="sr-only"> Packed orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.truck class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Shipped
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $orders->shipped }}
                            <span class="text-sm subcopy">/ {{ $lifetime_orders->shipped }}</span>
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=shipped"
                        >
                            View all<span class="sr-only"> Shipped orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.tick class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Completed
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $orders->completed }}
                            <span class="text-sm subcopy">/ {{ $lifetime_orders->completed }}</span>
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=completed"
                        >
                            View all<span class="sr-only"> Completed orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                        <x-icons.cross class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Cancelled
                        </p>
                        <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                            {{ $orders->cancelled }} <span class="text-sm subcopy">/
                                {{ $lifetime_orders->cancelled }}</span>
                        </p>
                    </div>
                </div>
                <x-slot:footer>
                    <div class="text-sm">
                        <a
                            class="link"
                            href="/orders?filter=cancelled"
                        >
                            View all<span class="sr-only"> Cancelled orders</span></a>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            @if (auth()->user()->hasPermissionTo('create purchase'))
                <x-stat-container>
                    <div class="flex items-start">
                        <div class="p-3 bg-teal-500 rounded-md dark:bg-slate-900">
                            <x-icons.exclamation class="w-6 h-6 text-teal-100 dark:text-teal-500" />
                        </div>
                        <div class="ml-6">
                            <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                                Pending Purchases
                            </p>
                            <p class="text-2xl font-semibold text-teal-800 dark:text-teal-500">
                                {{ $pendingPurchases }}
                            </p>
                        </div>
                    </div>
                    <x-slot:footer>
                        <div class="text-sm">
                            <a
                                class="link"
                                href="{{ route('purchases/pending') }}"
                            >
                                View all<span class="sr-only"> Pending purchases</span></a>
                        </div>
                    </x-slot:footer>
                </x-stat-container>
            @endif
        </div>
    </div>

    <div class="p-6 my-4 w-full bg-white rounded-lg shadow dark:text-teal-400 text-slate-500 dark:bg-slate-800">
        <x-page-header>
            Vape Crew 2.0
        </x-page-header>
        <p>
            Change: update complete ui
        </p>
        <p>
            Change: merge products and inventory
        </p>
        <p>
            Change: Change orders / credits / purchases / supplier credits modules
        </p>
        <p>
            Enhancement: Complete new search engine
        </p>
        <p>
            Enhancement: Rewrote complete codebase - performance improvement
            of over 70%
        </p>
    </div>
</div>
