<a
    {{ $attributes->merge(['class' => 'text-sm font-semibold underline underline-offset-4 text-slate-500
                      hover:text-white transition duration-150']) }}>
    <div class="flex items-center">
        {{ $slot }}
    </div>
</a>
