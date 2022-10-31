@props([
    'formId'
])
<div>
    <button
        x-data="{disabled:false}"
        x-on:click="disabled = true; document.getElementById('{{$formId}}').submit(); setTimeout(() => this.disabled = false,3000)"
        x-bind:disabled="disabled"
        x-bind:class="{'opacity-50': disabled}"
        {{ $attributes }}
        {{ $attributes->merge(['type' => 'submit','class' => 'inline-flex w-full items-center rounded-md border border-transparent bg-slate-800 px-4 py-2 text-xs uppercase font-medium text-white shadow hover:shadow-none hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2']) }}>
        <x-icons.refresh x-show="disabled"
                         class="animate-spin mr-4 w-3 h-3"
        />
        {{ $slot }}
    </button>
</div>
