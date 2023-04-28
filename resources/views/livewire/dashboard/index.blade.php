<div wire:poll.3000ms>

    <div class="px-2 text-lg">
        <h1 class="font-bold dark:text-white text-slate-900">{{ date('F') }}</h1>
    </div>

    <div class="mt-4 bg-white rounded-lg shadow dark:bg-slate-900">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-2 gap-px bg-white rounded-lg sm:grid-cols-2 lg:grid-cols-4 dark:bg-slate-900">
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Received</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-4xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                               {{ $lifetime_orders->received }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Processed</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-4xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                            {{ $lifetime_orders->processed }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Packed</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-4xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                            {{ $lifetime_orders->packed }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Shipped</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-4xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                            {{ $orders->shipped }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="mt-4">
        <div class="grid grid-cols-1 gap-5 mt-4 sm:grid-cols-2 lg:grid-cols-3">


            @if (auth()->user()->hasPermissionTo('upgrade customers'))
                <a href="{{ route('customers/wholesale/applications') }}"
                   class="inline-flex items-center py-4 px-4 text-xs font-medium text-rose-900 rounded-md ring-1 ring-inset dark:text-rose-400 ring-rose-400/20 bg-rose-400/20 dark:bg-rose-400/10 dark:hover:bg-rose-400/20 hover:bg-rose-400/40"
                >
                    <div class="flex justify-between items-center w-full">
                        <p>{{ $wholesaleApplications }} Pending Wholesale Applications</p>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-6 h-6"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </div>
                </a>
            @endif

            @if (auth()->user()->hasPermissionTo('create purchase'))
                <a href="{{ route('purchases/pending') }}"
                   class="inline-flex items-center py-4 px-4 text-xs font-medium text-rose-900 rounded-md ring-1 ring-inset dark:text-rose-400 ring-rose-400/20 bg-rose-400/20 dark:bg-rose-400/10 dark:hover:bg-rose-400/20 hover:bg-rose-400/40"
                >
                    <div class="flex justify-between items-center w-full">
                        <p>{{ $pendingPurchases }} Pending Purchases</p>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="w-6 h-6"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </div>
                </a>
            @endif

            <div></div>

            @if (auth()->user()->hasPermissionTo('view reports'))
                @if ($topTenProducts->count())
                    <x-stat-container>
                        <div>
                            <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-800">
                                <p class="text-xs font-semibold text-white">
                                    Top Ten Selling Products for {{ date('M  Y') }}</p>
                            </div>
                            <ul class="mt-2">
                                @foreach ($topTenProducts as $product)
                                    <li
                                        class="p-2 mb-2 rounded odd:bg-white dark:odd:bg-slate-900 dark:even:bg-slate-800 even:bg-slate-100"
                                    >
                                        <div class="flex justify-between items-start">
                                            <x-product-listing-simple
                                                :product="$product"
                                                wire:key="'product-'{{ $product->id }}"
                                            />
                                            <div class="text-xs font-semibold text-right text-sky-800 dark:text-sky-500">
                                                <p>{{ 0 - ($product->sold + $product->credits) }} units</p>
                                                @if ($product->available > 0)
                                                    <p>{{ $product->available  }} in stock</p>
                                                @else
                                                    <p class="text-xs text-rose-600">sold out !</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <x-slot:footer>
                            <div class="text-sm">
                                <a
                                    class="link"
                                    href="{{ route('reports') }}"
                                >
                                    View all Reports</a>
                            </div>
                        </x-slot:footer>
                    </x-stat-container>
                @endif
            @endif

        </div>
    </div>

</div>
