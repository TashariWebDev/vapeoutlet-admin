<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            height: 100%;
        }


        @media print {
            /*section,*/
            /*td,*/
            /*tr,*/
            /*div,*/
            section {
                page-break-inside: avoid;
            }


            @page {
                margin-top: 10mm;
                margin-bottom: 10mm;
                size: a4 portrait;
            }

            @page :first {
                margin-top: 10;
                margin-bottom: 10mm;
                size: a4 portrait;
            }

        }

    </style>
</head>
<body>
<div class="font-sans w-screen bg-white antialiased overflow-hidden p-4">

    <div class="px-4">
        {{ date("Y-m-d h:i:sa") }}
    </div>

    <table class="w-full">
        <thead>
        <tr class="px-2 py-1 uppercase font-bold bg-gray-900 text-white">
            <th class="text-left">SKU</th>
            <th class="text-left">PRODUCT DESCRIPTION</th>
            <th class="text-right">QTY</th>
            <th class="text-right">PRICE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productsGroupedByCategory as $category)
            @foreach($category as $product)
                @if($loop->first)
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="6" class="text-left">{{$product->category}}</td>
                    </tr>
                @endif
                <tr class="break-inside-avoid border-b border-dashed">
                    <td class="text-left">
                        <p class="text-xs font-medium text-gray-900">{{ $product->sku }}</p>
                    </td>
                    <td class="text-left">
                        <div>
                            <p class="text-xs text-gray-500">
                                {{ ucwords($product->brand) }} {{ ucwords($product->name)}}
                            </p>
                            <div class="flex flex-wrap justify-start">
                                @foreach($product->features as $feature)
                                    <p class="text-gray-500 text-xs pr-2">{{$feature->name}}</p>
                                @endforeach
                            </div>
                        </div>
                    </td>
                    <td class="text-right">
                        <p class="text-xs text-gray-500 font-semibold">
                            {{ $product->qty() }}</p>
                    </td>
                    <td class="text-right">
                        <p class="text-xs text-gray-500 font-semibold">
                            R {{ number_format($product->getPriceByRole($customer),2) }}</p>
                    </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
