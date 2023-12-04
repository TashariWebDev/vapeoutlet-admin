@props(['product'])

<div>

    <div class="pb-0.5">
        <p class="font-semibold tracking-wider text-[12px] text-slate-600 dark:text-slate-500">
            {{ $product->sku }}
        </p>
    </div>
    <div class="leading-4">
        <p class="font-bold tracking-wide text-[14px] text-slate-800 dark:text-slate-400">
            {{ $product->brand }} {{ $product->name }}
        </p>
        <ul class="flex font-semibold list-inside text-[12px]">
            @foreach ($product->features as $feature)
                <li class="pr-2 tracking-wide uppercase text-slate-800 dark:text-slate-400"> {{ $feature->name }}</li>
            @endforeach
        </ul>
    </div>
    <div class="pt-0.5">
        <p class="font-semibold tracking-wider text-[12px] text-slate-600 dark:text-slate-500">
            {{ $product->category }}
        </p>
    </div>

</div>
