<div>
    <button
        wire:loading.attr="disabled"
        wire:loading.class="opacity-50'"
        wire:target="{{ $targetClass }}"
        {{ $attributes }}
        {{ $attributes->merge(['type' => 'submit','class' => 'inline-flex w-full items-center rounded-md border border-transparent bg-slate-800 px-4 py-2 text-xs uppercase font-medium text-white shadow hover:shadow-none hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2']) }}>
        <x-icons.refresh wire:loading
                         wire:target="{{ $targetClass }}"
                         class="animate-spin mr-4 w-3 h-3"
        />
        {{ $slot }}
    </button>
</div>
