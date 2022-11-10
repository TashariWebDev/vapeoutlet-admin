<div class="mt-1">
    <select
        {{ $attributes->merge(['class' => 'block w-full rounded-md bg-white dark:bg-slate-700 text-slate-700 dark:text-white border-slate-700 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm']) }}
    >
        {{ $slot }}
    </select>
</div>
