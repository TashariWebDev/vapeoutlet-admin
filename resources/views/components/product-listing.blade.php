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
      <p class="pr-1 text-xs text-slate-600 dark:text-slate-300"> {{ $feature->name }}</p>
    @endforeach
  </div>
  <p class="font-semibold text-slate-800 dark:text-sky-800">
    {{ $product->category }}
  </p>
  @if (str_contains($product->image, '/storage/images/no_image.jpeg'))
    <p class="text-xs font-semibold text-rose-800 dark:text-rose-600">
      ! featured image not set
    </p>
  @endif
</div>
