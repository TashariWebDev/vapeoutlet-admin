@props(['product'])

<div>
    <p class="text-sm font-semibold tracking-wide text-slate-600 dark:text-slate-500">
        {{ $product->sku }}
    </p>
    <p class="text-sm font-bold text-slate-800 dark:text-slate-400">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <ul class="flex text-xs list-inside">
        @foreach ($product->features as $feature)
            <li class="pr-2 font-medium tracking-wide text-slate-900 dark:text-slate-400"> {{ $feature->name }}</li>
        @endforeach
    </ul>
</div>
