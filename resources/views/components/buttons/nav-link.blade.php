@props([
    'name'
])

<a {{ $attributes }}
   class="@if( str_contains(request()->path(),$name) ) font-semibold text-white bg-slate-800 shadow-md  @endif text-slate-400  group flex items-center px-2 py-1 text-sm rounded-md hover:font-semibold hover:text-white"
>
    {{ $slot }}
</a>
