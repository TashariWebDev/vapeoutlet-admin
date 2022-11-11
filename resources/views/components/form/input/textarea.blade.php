<!--suppress HtmlFormInputWithoutLabel -->
<div class="mt-1">
    <textarea
        {{ $attributes->merge(['class' => 'block w-full rounded-md py-2.5 border-slate-300 dark:border-slate-700 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm']) }}
        rows="4"
    >{{ $slot }}</textarea>
</div>
