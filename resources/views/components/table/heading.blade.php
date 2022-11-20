<div
    {{ $attributes->merge(['class' => 'text-xs font-bold px-1 lg:px-2 uppercase text-slate-500 dark:text-slate-400']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
