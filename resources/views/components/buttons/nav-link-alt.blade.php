@props([
    'name'
])

<a {{ $attributes }}
   class="@if( str_contains(request()->path(),$name) ) font-semibold @endif bg-white text-slate-900 group flex items-center px-2 py-2 text-sm rounded-md hover:font-semibold shadow"
>
    {{ $slot }}
</a>
