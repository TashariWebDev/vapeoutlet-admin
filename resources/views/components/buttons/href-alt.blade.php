<a
    {{ $attributes->merge(['class' => 'text-xs font-semibold underline underline-offset-4 text-slate-500
hover:text-slate-800 transition duration-150']) }}>
    <div class="flex items-center">
        {{ $slot }}
    </div>
</a>
