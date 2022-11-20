<button
    {{ $attributes }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-pink-200 px-4 py-2 text-xs uppercase font-medium text-pink-700 hover:bg-pink-300 shadow hover:shadow-none focus:outline-none focus:ring-2 focus:bg-pink-300 focus:ring-pink-500 focus:ring-offset-2']) }}
>
    {{ $slot }}
</button>
