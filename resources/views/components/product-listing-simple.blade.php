@props(['product'])

<div>
    <p class="text-sm font-semibold text-slate-500 dark:text-slate-500">
        {{ $product->sku }}
    </p>
    <p class="text-sm font-semibold dark:text-white text-slate-800">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-0.5 text-xs">
        @foreach ($product->features as $feature)
            <p class="pr-1 dark:text-white text-slate-800"> {{ $feature->name }}</p>
        @endforeach
    </div>
</div>
