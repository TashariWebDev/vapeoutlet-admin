<div
    {{ $attributes->merge(['class' => 'text-xs font-bold px-1 lg:px-2 pb-2 uppercase text-sky-900 dark:text-slate-300']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
