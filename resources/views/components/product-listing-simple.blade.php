@props(['product'])

<div>
    <p class="text-xs font-medium text-slate-700 dark:text-slate-400">
        {{ $product->sku }}
    </p>
    <p class="text-xs font-semibold text-slate-700 dark:text-slate-400">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-1">
        @foreach ($product->features as $feature)
            <p class="pr-1 text-xs text-slate-700 dark:text-slate-400"> {{ $feature->name }}</p>
        @endforeach
    </div>
</div>
