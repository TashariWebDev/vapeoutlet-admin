<div
    class="flex overflow-hidden flex-col w-full bg-white rounded-lg shadow dark:border border-slate-900 dark:bg-slate-900"
>
    <div class="px-6 pt-6 pb-10 h-full">
        {{ $slot }}
    </div>
    <div class="py-3 px-6 bg-slate-100 dark:bg-slate-800">
        {{ $footer }}
    </div>
</div>
