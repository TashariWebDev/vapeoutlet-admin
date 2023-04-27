<!--suppress HtmlFormInputWithoutLabel -->
<div class="mt-1">
    <textarea
        {{ $attributes->merge(['class' => 'block w-full rounded-md px-4 py-2 bg-slate-100 dark:text-blue-100 dark:bg-slate-800 text-slate-700  border-slate-200 dark:border-slate-600 shadow-sm focus:border-blue-400 focus:ring-blue-400 text-xs']) }}
        rows="4"
    >{{ $slot }}</textarea>
</div>
