@props(['product'])

<div>
    <p class="text-xs font-semibold dark:text-white text-slate-800">
        {{ $product->sku }}
    </p>
    <p class="text-xs font-semibold dark:text-white text-slate-800">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-0.5 text-[10px]">
        @foreach ($product->features as $feature)
            <p class="pr-1 dark:text-white text-slate-800"> {{ $feature->name }}</p>
        @endforeach
    </div>
</div>
