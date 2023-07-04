<!--suppress HtmlFormInputWithoutLabel -->
<div>
    <select
        {{ $attributes->merge(['class' => 'block w-full rounded-md px-4 py-1.5 bg-slate-100 dark:text-slate-100 dark:bg-slate-800 text-slate-700 border-slate-200 dark:border-slate-800 focus:border-slate-400 focus:ring-slate-400 text-sm']) }}
    >
        {{ $slot }}
    </select>
</div>
