<!--suppress HtmlFormInputWithoutLabel -->
<div class="mt-1">
    <select
        {{ $attributes->merge(['class' => 'block w-full py-2.5 rounded-md bg-white dark:bg-slate-700 text-slate-700 dark:text-white border-slate-300 dark:border-slate-700 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm']) }}
    >
        {{ $slot }}
    </select>
</div>
