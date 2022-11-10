<div
    {{ $attributes->merge(['class' => 'text-sm font-bold px-1 lg:px-2 uppercase text-slate-700 dark:text-slate-400']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
