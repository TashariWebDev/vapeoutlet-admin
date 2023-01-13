<div wire:poll.3000ms>

    <div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <x-stat-container>
                <div class="flex items-start">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.shopping-bag class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Received
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.clipboard class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Processed
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.products class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Packed
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.truck class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Shipped
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.tick class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Completed
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                        <x-icons.cross class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                    </div>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                            Cancelled
                        </p>
                        <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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
                        <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
                            <x-icons.exclamation class="w-6 h-6 text-sky-100 dark:text-sky-500" />
                        </div>
                        <div class="ml-6">
                            <p class="text-sm font-medium text-slate-400 truncate dark:text-slate-400">
                                Pending Purchases
                            </p>
                            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-500">
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

    <div class="py-10 text-slate-800 dark:text-slate-500">
        <h2>Latest updates</h2>
        <div class="py-4">

            <ul>
                <li>Update ui colours for easier readability</li>
                <li>Implemented Sale Channel Module</li>
                <li>Warranty report (under transaction report)</li>
                <li>Debits report (under transaction report)</li>
                <li>Cash up module</li>
                <li>Updated stock take module (under admin)</li>
            </ul>

            <ul class="py-4">
                <li>Cash up module (ensure you have the can complete sale permision)</li>
                <li class="underline underline-offset-2">Usage</li>
            </ul>

            <ol class="py-2 px-10 list-decimal">
                <li>Select cash up under admin</li>
                <li>You will see all orders per sales channel that are <strong
                        class="underline underline-offset-2">shipped</strong>
                </li>
                <li>You can filter orders by sales channel</li>
                <li>You can preview a customers account and allocate a payment to that customer</li>
                <li>You can complete the order</li>
            </ol>

            <ul class="py-4">
                <li>Sales Channels</li>
                <li class="underline underline-offset-2">Set up</li>
            </ul>
            <ol class="py-2 px-10 list-decimal">
                <li>Create Sales Channels under Admin</li>
                <li>Allocate users to sales channel and set default under admin/users</li>
                <li>Transfer stock to sales channel under admin</li>
                <li>Print the stock transfer</li>
                <li>Stock to be checked by receiver and signed off</li>
                <li>On the Product screen, select stock tracking and you can monitor stock movement in all sales
                    channels
                </li>
            </ol>
            <ul class="py-4">
                <li class="underline underline-offset-2">Usage</li>
            </ul>
            <ol class="py-2 px-10 list-decimal">
                <li>For users with only one channel allocated to them just log in and process orders as normal</li>
                <li>For users with more than one channel , in the top bar select the channel you want to transact in and
                    then process as normal
                </li>
                <li>
                    For credit notes ensure that you are on the correct channel and process as normal.stock will be
                    credited and made available to the appropriate bin
                </li>
                <li>
                    for convenience appropriate sales channel will be listed on all invoices and credit notes
                </li>
            </ol>

            <ul class="py-4">
                <li>Stock take module</li>
                <li class="underline underline-offset-2">Usage</li>
            </ul>

            <ol class="py-2 px-10 list-decimal">
                <li>Select stock take in admin</li>
                <li>
                    Make sure you are on the correct sales channel and create stock takes as usual
                </li>
                <li>Create stock take</li>
                <li>You will now only see products and brands available to that channel</li>
                <li>You can now only have one stock take per brand and sales channel open at a time</li>
                <li>Please delete any unprocessed stock takes</li>

            </ol>
        </div>
    </div>

</div>
