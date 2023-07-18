<div
    class="flex overflow-hidden flex-col w-full bg-white rounded-md shadow-sm dark:border shadow-slate-300 border-slate-900 dark:shadow-black dark:bg-slate-900"
>
    <div class="py-6 px-6 h-full">
        {{ $slot }}
    </div>
    <div class="py-2 px-6 text-sm font-semibold bg-slate-100 dark:bg-slate-800">
        {{ $footer }}
    </div>
</div>
