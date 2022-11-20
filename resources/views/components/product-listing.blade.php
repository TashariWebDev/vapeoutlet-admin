@props(['product'])

<div>
    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
        {{ $product->sku }}
    </p>
    <p class="font-semibold text-slate-800 dark:text-slate-300">
        {{ $product->name }} {{ $product->name }}
    </p>
    <div class="flex items-center space-x-1">
        @foreach ($product->features as $feature)
            <p class="pr-1 text-xs text-slate-500 dark:text-slate-400"> {{ $feature->name }}</p>
        @endforeach
    </div>
    <p class="font-semibold dark:text-teal-800 text-slate-800">
        {{ $product->category }}
    </p>
    @if (str_contains($product->image, '/storage/images/default-image.png'))
        <p class="text-xs font-semibold text-pink-800 dark:text-pink-500">
            ! featured image not set
        </p>
    @endif
</div>
