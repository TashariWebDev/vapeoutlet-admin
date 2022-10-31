<button
    {{ $attributes }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-red-200 px-4 py-2 text-xs uppercase font-medium text-red-700 hover:bg-red-300 shadow hover:shadow-none focus:outline-none focus:ring-2 focus:bg-red-300 focus:ring-red-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
