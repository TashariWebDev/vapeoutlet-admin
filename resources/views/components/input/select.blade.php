<!--suppress HtmlFormInputWithoutLabel -->
<div class="mt-1">
    <select
        {{ $attributes->merge(['class' => 'block w-full rounded-md px-4 py-2.5 mt-2 bg-slate-100 dark:text-slate-100 dark:bg-slate-800 text-slate-700 border-slate-200 dark:border-slate-800 focus:border-slate-400 focus:ring-slate-400 text-xs']) }}
    >
        {{ $slot }}
    </select>
</div>
