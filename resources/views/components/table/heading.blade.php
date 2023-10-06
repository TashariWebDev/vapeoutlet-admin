<div
    {{ $attributes->merge(['class' => 'px-1 pb-3 text-xs font-extrabold tracking-wide uppercase text-slate-500 dark:text-slate-500']) }}>
    <p>
        {{ $slot }}
    </p>
</div>
