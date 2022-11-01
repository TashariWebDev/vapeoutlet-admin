<div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        @hasPermissionTo('view expenses')
        <a href="{{ route('expenses') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Expenses
        </a>
        @endhasPermissionTo

        @hasPermissionTo('view reports')
        <a href="{{ route('reports') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Reports
        </a>
        @endhasPermissionTo

        @hasPermissionTo('view users')
        <a href="{{ route('users') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Users
        </a>
        @endhasPermissionTo
    </div>

    <div class="h-0.5 bg-slate-900/20 my-2"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <a href="{{ route('settings/delivery') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Delivery settings
        </a>

        <a href="{{ route('settings/marketing/notifications') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Marketing notifications
        </a>

        <a href="{{ route('settings/marketing/banners') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Marketing banners
        </a>


        <a href="{{ route('settings/categories/edit') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Manage Categories
        </a>

        <a href="{{ route('settings/brands/edit') }}"
           class="w-full h-24 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex justify-center items-center rounded-lg hover:ring font-bold focus:ring"
        >
            Manage Brands
        </a>

    </div>
</div>
