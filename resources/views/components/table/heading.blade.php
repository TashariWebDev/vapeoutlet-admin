<div
    {{ $attributes->merge(['class' => 'text-sm font-semibold px-1 lg:px-2 pb-2 uppercase text-slate-500 dark:text-slate-500']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
