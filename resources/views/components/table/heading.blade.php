<div
    {{ $attributes->merge(['class' => 'text-xs font-bold px-1 lg:px-2 uppercase text-slate-600 dark:text-slate-300']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
