@props(['product'])

<div>
    <p class="text-xs font-semibold dark:text-white text-slate-800">
        {{ $product->sku }}
    </p>
    <p class="text-xs dark:text-white text-slate-800">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-1">
        @foreach ($product->features as $feature)
            <p class="pr-1 text-xs dark:text-white text-slate-800"> {{ $feature->name }}</p>
        @endforeach
    </div>
</div>
