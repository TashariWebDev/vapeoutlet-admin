@props([
    'product'
])


<div>
    <p class="font-medium text-gray-500 text-xs">
        {{ $product->sku }}
    </p>
    <p class="font-semibold text-gray-800">
        {{ $product->brand }} {{ $product->name }}
    </p>
    <div class="flex space-x-1 items-center">
        @foreach($product->features as $feature)
            <p class="text-xs text-gray-600 pr-1 @if(!$loop->last) border-r @endif"
            > {{ $feature->name }}</p>
        @endforeach
    </div>
    <p class="font-semibold text-gray-800">
        {{ $product->category}}
    </p>
    @if( str_contains($product->image,'/storage/images/default-image.png'))
        <p class="font-semibold text-red-800 text-xs">
            ! featured image not set
        </p>
    @endif
</div>
