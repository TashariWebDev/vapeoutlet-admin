<!--suppress HtmlFormInputWithoutLabel -->
<div>
    <textarea
        {{ $attributes->merge(['class' => 'block w-full rounded-md px-4 py-1.5 bg-slate-100 dark:text-sky-100 dark:bg-slate-800 text-slate-700  border-slate-200 dark:border-slate-600 shadow-sm focus:border-sky-400 focus:ring-sky-400 text-sm']) }}
        rows="4"
    >{{ $slot }}</textarea>
</div>
