<div>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500 dark:text-slate-300">Sales Channels & Stock
        Management</h2>
    </div>

    @hasPermissionTo('edit sales channels')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('sales-channels') }}"
      >
        Sales channels
      </a>
    @endhasPermissionTo

    @hasPermissionTo('transfer stock')
      @if ($salesChannelCount > 1)
        <a
          class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
          href="{{ route('stock-transfers') }}"
        >
          Stock transfers
        </a>
      @endif
    @endhasPermissionTo

    @hasPermissionTo('manage stock takes')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('stock-takes') }}"
      >
        Stock takes
      </a>
    @endhasPermissionTo

    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500 dark:text-slate-300">Financial</h2>
    </div>

    @hasPermissionTo('complete orders')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('cash-up') }}"
      >
        Cash Up
      </a>
    @endhasPermissionTo

    @hasPermissionTo('view expenses')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('expenses') }}"
      >
        Expenses
      </a>
    @endhasPermissionTo

    @hasPermissionTo('view reports')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('reports') }}"
      >
        Reports
      </a>
    @endhasPermissionTo

    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500 dark:text-slate-300">System Settings</h2>
    </div>

    @hasPermissionTo('view users')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('users') }}"
      >
        Users
      </a>
    @endhasPermissionTo

    @hasPermissionTo('view reports')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('delivery') }}"
      >
        Delivery settings
      </a>

      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('system-settings') }}"
      >
        System settings
      </a>
    @endhasPermissionTo

    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500 dark:text-slate-300">Marketing</h2>
    </div>

    @hasPermissionTo('edit products')
      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('banners') }}"
      >
        Banners
      </a>

      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('notifications') }}"
      >
        Notifications
      </a>
    @endhasPermissionTo

    @hasPermissionTo('edit products')
      <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
        <h2 class="font-bold text-slate-500 dark:text-slate-300">Product Management</h2>
      </div>

      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('categories') }}"
      >
        Categories
      </a>

      <a
        class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg shadow hover:ring focus:ring text-slate-600 ring-sky-400 dark:bg-slate-800 dark:text-sky-300"
        href="{{ route('brands') }}"
      >
        Brands
      </a>
    @endhasPermissionTo

  </div>
</div>
