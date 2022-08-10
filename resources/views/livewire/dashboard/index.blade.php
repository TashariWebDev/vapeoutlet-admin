<div wire:poll.3000ms>
    <div>
        <h3 class="text-lg leading-6 font-bold text-gray-900">Orders</h3>

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.shopping-bag class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Received
                    </p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->received }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=received" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Received orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.clipboard class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Processed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->processed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=processed" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Processed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.products class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Packed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->packed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=packed" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Packed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.truck class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Shipped
                    </p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->shipped }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=shipped" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Shipped orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.tick class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Completed</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->completed }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=completed" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Completed orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>

            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute bg-green-500 rounded-md p-3">
                        <x-icons.cross class="w-6 h-6 text-white"/>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Cancelled</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $orders->cancelled }}
                    </p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="/orders?filter=cancelled" class="font-medium text-green-600 hover:text-green-500">
                                View all<span
                                    class="sr-only"> Cancelled orders</span></a>
                        </div>
                    </div>
                </dd>
            </div>
        </dl>
    </div>


</div>
