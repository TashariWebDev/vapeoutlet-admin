<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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


            @page :first {
                margin-top: 0;
                margin-right: 5mm;
                margin-left: 5mm;
                margin-bottom: 25mm;
                size: letter portrait;
            }

        }

    </style>
</head>
<body>
<div class="font-sans w-screen bg-white antialiased overflow-hidden">

    <div>
        {{ date("Y-m-d h:i:sa") }}
    </div>

    <div>
        @foreach($products as $product)
            <div class="grid grid-cols-4 gap-y-3  border-b py-2">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $product->sku }}</p>
                </div>
                <div class="col-span-2 flex items-center space-x-2">
                    <div>
                        <p class="text-sm text-gray-500">
                            {{ ucwords($product->brand) }} {{ ucwords($product->name)}}
                        </p>
                        <div class="flex flex-wrap justify-start">
                            @foreach($product->features as $feature)
                                <p class="text-gray-500 text-xs pr-2">{{$feature->name}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500 font-semibold">
                        R {{ number_format($product->getPriceByRole($customer),2) }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
