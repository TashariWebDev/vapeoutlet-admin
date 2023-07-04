<div wire:poll.3000ms>

    <div x-data="{
        bannerVisible: false,
        bannerVisibleAfter: 300
    }"
         x-show="bannerVisible"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="-translate-y-10"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="-translate-y-10"
         x-init="
        setTimeout(()=>{ bannerVisible = true }, bannerVisibleAfter);"
         class="fixed bottom-0 left-0 py-2 w-full h-auto bg-white shadow-sm duration-300 ease-out sm:py-0 sm:h-10 dark:bg-slate-900"
         x-cloak
    >
        <div class="flex justify-between items-center px-3 mx-auto w-full max-w-7xl h-full">
            <a href="{{ route('changelog') }}"
               class="flex flex-col w-full h-full text-xs leading-6 text-black opacity-80 duration-150 ease-out sm:flex-row sm:items-center dark:text-white hover:opacity-100"
            >
            <span class="flex items-center">
                <svg class="mr-1 w-4 h-4"
                     viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                ><g fill="none"
                    stroke="none"
                    ><path d="M10.1893 8.12241C9.48048 8.50807 9.66948 9.5633 10.4691 9.68456L13.5119 10.0862C13.7557 10.1231 13.7595 10.6536 13.7968 10.8949L14.2545 13.5486C14.377 14.3395 15.4432 14.5267 15.8333 13.8259L17.1207 11.3647C17.309 11.0046 17.702 10.7956 18.1018 10.8845C18.8753 11.1023 19.6663 11.3643 20.3456 11.4084C21.0894 11.4567 21.529 10.5994 21.0501 10.0342C20.6005 9.50359 20.0352 8.75764 19.4669 8.06623C19.2213 7.76746 19.1292 7.3633 19.2863 7.00567L20.1779 4.92643C20.4794 4.23099 19.7551 3.52167 19.0523 3.82031L17.1037 4.83372C16.7404 4.99461 16.3154 4.92545 16.0217 4.65969C15.3919 4.08975 14.6059 3.39451 14.0737 2.95304C13.5028 2.47955 12.6367 2.91341 12.6845 3.64886C12.7276 4.31093 13.0055 5.20996 13.1773 5.98734C13.2677 6.3964 13.041 6.79542 12.658 6.97364L10.1893 8.12241Z"
                           stroke="currentColor"
                           stroke-width="1.5"
                        ></path><path d="M12.1575 9.90759L3.19359 18.8714C2.63313 19.3991 2.61799 20.2851 3.16011 20.8317C3.70733 21.3834 4.60355 21.3694 5.13325 20.8008L13.9787 11.9552"
                                      stroke="currentColor"
                                      stroke-width="1.5"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                        ></path><path d="M5 6.25V3.75M3.75 5H6.25"
                                      stroke="currentColor"
                                      stroke-width="1.5"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                        ></path><path d="M18 20.25V17.75M16.75 19H19.25"
                                      stroke="currentColor"
                                      stroke-width="1.5"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                        ></path></g></svg>
                <strong class="font-semibold">New Features</strong><span class="hidden mx-3 w-px h-4 rounded-full sm:block bg-neutral-200"></span>
            </span>
                <span class="block pt-1 pb-2 leading-none sm:inline sm:pt-0 sm:pb-0">Click here to learn about our latest features</span>
            </a>
            <button @click="bannerVisible=false"
                    class="flex flex-shrink-0 justify-center items-center p-1.5 w-6 h-6 text-black rounded-full duration-150 ease-out translate-x-1 dark:text-white hover:bg-neutral-100"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-full h-full"
                >
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>

    <div class="px-2">
        <h1 class="text-2xl font-bold dark:text-white text-slate-900">{{ date('F') }}</h1>
    </div>

    <div class="mt-4 bg-white rounded-lg shadow-lg dark:bg-slate-900">
        <div class="mx-auto">
            <div class="grid grid-cols-2 gap-px bg-white rounded-lg sm:grid-cols-2 lg:grid-cols-4 dark:bg-slate-900">
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Received</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-3xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                               {{ $lifetime_orders->received }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Processed</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-3xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                            {{ $lifetime_orders->processed }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Packed</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-3xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
                            {{ $lifetime_orders->packed }}
                        </span>
                    </p>
                </div>
                <div class="py-6 px-4 bg-white rounded-lg sm:px-6 lg:px-8 dark:bg-slate-900">
                    <p class="text-sm font-medium leading-6 text-slate-600 dark:text-slate-400">Shipped</p>
                    <p class="flex gap-x-2 items-baseline mt-2">
                        <span class="text-3xl font-semibold tracking-tight text-sky-800 dark:text-sky-400">
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
                   class="inline-flex items-center py-4 px-4 text-xs font-medium text-rose-900 rounded-md ring-1 ring-inset shadow-lg dark:text-rose-400 hover:shadow-none ring-rose-400/20 bg-rose-400/20 dark:bg-rose-400/10 dark:hover:bg-rose-400/20 hover:bg-rose-400/40"
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
                   class="inline-flex items-center py-4 px-4 text-xs font-medium text-rose-900 rounded-md ring-1 ring-inset shadow-lg dark:text-rose-400 hover:shadow-none ring-rose-400/20 bg-rose-400/20 dark:bg-rose-400/10 dark:hover:bg-rose-400/20 hover:bg-rose-400/40"
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
                            <div class="py-3 px-2 rounded-lg bg-sky-500 dark:bg-slate-800">
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
