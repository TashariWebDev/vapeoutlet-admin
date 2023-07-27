@props([
  'text'
])
<p {{ $attributes->merge(['class' => 'relative cursor-copy']) }} @click="navigator.clipboard.writeText(text);show = true"
   x-data="{text : '{{ $text }}', show : false}"
   x-init="$watch('show', value => setTimeout(() => show = false,1000))"
   title="click to copy"
>
    {{ $slot }}

    <span x-show="show === true"
          class="flex overflow-auto absolute top-0 z-50 items-center p-0.5 font-semibold text-green-100 whitespace-nowrap bg-green-800 rounded text-[8px]"
    >&ast; copied</span>
</p>
