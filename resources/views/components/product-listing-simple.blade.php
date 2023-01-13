@props(['product'])

<div>
    <p class="text-xs font-medium text-slate-600 dark:text-sky-400">
        {{ $product->sku }}
    </p>
    <p class="text-xs text-slate-600 dark:text-slate-400">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-1">
        @foreach ($product->features as $feature)
            <p class="pr-1 text-xs text-slate-400 dark:text-slate-500"> {{ $feature->name }}</p>
        @endforeach
    </div>
</div>
