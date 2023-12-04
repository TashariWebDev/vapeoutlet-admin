@props(['product'])

<div>
    <p class="text-xs font-medium text-slate-600 dark:text-slate-300">
        {{ $product->sku }}
    </p>
    <p class="font-semibold text-slate-800 dark:text-slate-300">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-1">
        @foreach ($product->features as $feature)
            <p class="text-xs even:pr-1 text-slate-600 dark:text-slate-300"> {{ $feature->name }}</p>
        @endforeach
    </div>
    <p class="font-medium text-[12px] text-slate-800 dark:text-sky-800">
        {{ $product->category }}
    </p>

</div>
