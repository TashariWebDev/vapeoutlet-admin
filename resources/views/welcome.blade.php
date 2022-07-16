<x-guest-layout>

    <div class="max-w-7xl mx-auto py-20 text-center">
        @foreach($products as $product)
            <div class="pb-12 w-full">
                <p class="text-red-200 text-3xl font-bold ">
                    {{ $product->name }}
                </p>
                <p class="text-red-200 text-3xl font-bold ">
                    Money : {{ money($product->retail_price) }}
                </p>
                <p class="text-red-200 text-3xl font-bold ">
                    Rands: {{ to_rands($product->retail_price) }}
                </p>

                <p class="text-red-200 text-3xl font-bold ">
                    Vat: {{ vat($product->retail_price) }}
                </p>

                <p class="text-red-200 text-3xl font-bold ">
                    Ex Vat: {{ ex_vat($product->retail_price) }}
                </p>
            </div>
        @endforeach
    </div>
</x-guest-layout>
