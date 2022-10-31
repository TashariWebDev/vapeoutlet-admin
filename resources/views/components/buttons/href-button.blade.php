<a
    {{ $attributes }}
    {{ $attributes->merge(['class' => 'inline-flex w-full lg:w-64 items-center rounded-md border border-transparent bg-slate-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2']) }}>
    <div class="flex items-center">
        {{ $slot }}
    </div>
</a>
