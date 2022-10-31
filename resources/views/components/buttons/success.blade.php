<button
    {{ $attributes }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-green-200 px-4 py-2 text-xs uppercase font-medium text-green-700 hover:bg-green-300 shadow hover:shadow-none focus:outline-none focus:ring-2 focus:bg-green-300 focus:ring-green-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
