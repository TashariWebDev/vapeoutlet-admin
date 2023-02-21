<div wire:poll.3000ms>

  <div>
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <x-stat-container>
        <div class="flex items-start">
          <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
            <x-icons.shopping-bag class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Received
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
            <x-icons.clipboard class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Processed
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
            <x-icons.products class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Packed
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
            <x-icons.truck class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Shipped
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
            <x-icons.tick class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Completed
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
            <x-icons.cross class="w-6 h-6 text-sky-100 dark:text-sky-300" />
          </div>
          <div class="ml-6">
            <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
              Cancelled
            </p>
            <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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
              <x-icons.exclamation class="w-6 h-6 text-sky-100 dark:text-sky-300" />
            </div>
            <div class="ml-6">
              <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
                Pending Purchases
              </p>
              <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
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

      @if (auth()->user()->hasPermissionTo('upgrade customers'))
        <x-stat-container>
          <div class="flex items-start">
            <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900">
              <x-icons.exclamation class="w-6 h-6 text-sky-100 dark:text-sky-300" />
            </div>
            <div class="ml-6">
              <p class="text-sm font-medium truncate text-slate-400 dark:text-slate-400">
                Pending Wholesale Applications
              </p>
              <p class="text-2xl font-semibold text-sky-800 dark:text-sky-300">
                {{ $wholesaleApplications }}
              </p>
            </div>
          </div>
          <x-slot:footer>
            <div class="text-sm">
              <a
                class="link"
                href="{{ route('customers/wholesale/applications') }}"
              >
                View all<span class="sr-only"> Wholesale Applications</span></a>
            </div>
          </x-slot:footer>
        </x-stat-container>
      @endif

      <div>

      </div>

      @if (auth()->user()->hasPermissionTo('view reports'))
        @if ($topTenProducts->count())
          <x-stat-container>
            <div>
              <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-800">
                <p class="text-xs font-semibold text-white">Top Ten Selling Products
                  for {{ date('M  Y') }}</p>
              </div>
              <ul class="mt-2">
                @foreach ($topTenProducts as $product)
                  <li
                    class="p-2 mb-2 text-xs font-semibold rounded text-sky-800 dark:text-sky-300 dark:odd:bg-slate-900 dark:even:bg-slate-700 odd:bg-sky-50 even:bg-slate-100"
                  >
                    <div class="flex justify-between items-center">
                      <p>{{ $product->brand }} {{ $product->name }}</p>
                      <div>
                        <p>{{ 0 - $product->sold }} units</p>
                        @if ($product->available > 0)
                          <p>{{ $product->available }} in stock</p>
                        @else
                          <p class="text-xs text-red-600">sold out !</p>
                        @endif
                      </div>
                    </div>
                    <div class="flex items-center space-x-2">
                      @foreach ($product->features as $feature)
                        <p class="text-[10px]">{{ $feature->name }} </p>
                      @endforeach
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
