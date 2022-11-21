<div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        @hasPermissionTo('view expenses')
            <a
                class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
                href="{{ route('expenses') }}"
            >
                Expenses
            </a>
        @endhasPermissionTo

        @hasPermissionTo('view reports')
            <a
                class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
                href="{{ route('reports') }}"
            >
                Reports
            </a>
        @endhasPermissionTo

        @hasPermissionTo('view users')
            <a
                class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
                href="{{ route('users') }}"
            >
                Users
            </a>
        @endhasPermissionTo
    </div>

    <div class="my-2 h-0.5"></div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <a
            class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
            href="{{ route('delivery') }}"
        >
            Delivery settings
        </a>

        <a
            class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
            href="{{ route('notifications') }}"
        >
            Notifications
        </a>

        <a
            class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
            href="{{ route('banners') }}"
        >
            Banners
        </a>

        <a
            class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
            href="{{ route('categories') }}"
        >
            Categories
        </a>

        <a
            class="flex justify-center items-center w-full h-24 font-bold bg-white rounded-lg ring-teal-400 shadow dark:text-teal-600 hover:ring focus:ring text-slate-600 dark:bg-slate-800"
            href="{{ route('brands') }}"
        >
            Brands
        </a>

    </div>
</div>
