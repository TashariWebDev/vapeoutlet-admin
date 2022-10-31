<button
    {{ $attributes }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-slate-200 px-4 py-2 text-xs uppercase font-medium text-slate-700 hover:bg-slate-300 shadow hover:shadow-none focus:outline-none focus:ring-2 focus:bg-slate-300 focus:ring-slate-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
