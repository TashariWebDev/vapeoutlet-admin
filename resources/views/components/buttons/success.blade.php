<button
    {{ $attributes }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-teal-200 px-4 py-2 text-xs uppercase font-medium text-teal-700 hover:bg-teal-300 shadow hover:shadow-none focus:outline-none focus:ring-2 focus:bg-teal-300 focus:ring-teal-500 focus:ring-offset-2']) }}
>
    {{ $slot }}
</button>
