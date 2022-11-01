@props([
    'product'
])


<div>
    <p class="font-medium text-slate-500 dark:text-slate-400 text-xs">
        {{ $product->sku }}
    </p>
    <p class="font-semibold text-slate-800 dark:text-slate-300">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex space-x-1 items-center">
        @foreach($product->features as $feature)
            <p class="text-xs text-slate-500 dark:text-slate-400 pr-1"
            > {{ $feature->name }}</p>
        @endforeach
    </div>
    <p class="font-semibold text-slate-800 dark:text-green-800">
        {{ $product->category}}
    </p>
    @if( str_contains($product->image,'/storage/images/default-image.png'))
        <p class="font-semibold text-red-800 dark:text-red-500 text-xs">
            ! featured image not set
        </p>
    @endif
</div>
