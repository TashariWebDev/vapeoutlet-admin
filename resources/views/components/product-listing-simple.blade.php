@props(['product'])

<div>
    <p class="font-medium tracking-wide text-[12px] text-slate-600 dark:text-slate-500">
        {{ $product->sku }}
    </p>
    <div>
        <p class="font-bold text-[14px] text-slate-800 dark:text-slate-400">
            {{ $product->brand }} {{ $product->name }}
        </p>
    </div>
    <ul class="flex font-semibold list-inside text-[12px]">
        @foreach ($product->features as $feature)
            <li class="pr-2 tracking-wide uppercase text-slate-800 dark:text-slate-400"> {{ $feature->name }}</li>
        @endforeach
    </ul>
</div>
