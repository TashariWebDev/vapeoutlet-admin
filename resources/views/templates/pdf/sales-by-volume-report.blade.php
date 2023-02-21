<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >
  <title>{{ $brand }} Products sales by volume | {{ $from }} - {{ $to }}
  </title>

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
        margin-top: 10mm;
        margin-bottom: 10mm;
        size: a4 portrait;
      }
    }
  </style>
</head>

<body>
  <div class="overflow-hidden p-4 w-screen font-sans antialiased bg-white">

    <div class="break-inside-avoid break-after-avoid-page">
      <div class="px-4">
        <table class="w-full">
          <thead>
            <tr class="text-sm text-white bg-gray-800">
              <th
                class="col-span-2 text-left"
                colspan="2"
              >Product
              </th>
              <th class="text-center">Sold</th>
              <th class="text-center">D/Ave</th>
              <th class="text-center">In Stock</th>
              <th class="text-right"></th>
            </tr>
          </thead>
          <tbody class="text-xs">

            @php
              $noOfDays = Carbon\Carbon::parse($from)->diffIndays(Carbon\Carbon::parse($to));
            @endphp

            @foreach ($grouped as $products)
              @foreach ($products as $product)
                @if ($loop->first)
                  <tr class="col-span-4 text-white bg-gray-300">
                    <td
                      class="col-span-4 text-left"
                      colspan="2"
                    >
                      <p class="text-xs text-gray-800">
                        {{ $product->product_collection?->name ?? null }}</p>
                    </td>
                    <th class="text-center">Sold</th>
                    <th class="text-center">D/Ave</th>
                    <th class="text-center">In Stock</th>
                    <th class="text-right"></th>
                  </tr>
                @endif

                @php
                  $dailyAverage = (0 - $product->stocks_sum_qty) / $noOfDays;
                  $qtyInStock = $product->stocks->sum('qty');
                  
                  if ($dailyAverage * $qtyInStock > 0) {
                      $noOfDaysStocksAvailable = round($qtyInStock / $dailyAverage);
                  } else {
                      $noOfDaysStocksAvailable = 0;
                  }
                @endphp

                <tr class="py-1 border-b border-dashed break-inside-avoid-page">
                  <td
                    class="text-left"
                    colspan="2"
                  >
                    <p class="text-xs font-bold">{{ $product->brand }} {{ $product->name }}</p>
                    <p class="text-xs">{{ $product->sku }}</p>
                    <div class="flex items-center space-x-3">
                      @foreach ($product->features as $feature)
                        <p class="text-xs">{{ $feature->name }}</p>
                      @endforeach
                    </div>
                  </td>
                  <td class="text-center">{{ 0 - $product->stocks_sum_qty }}</td>
                  <td class="text-center">{{ $dailyAverage }}
                  </td>
                  <td class="text-center">
                    {{ $qtyInStock }}
                  </td>
                  <td class="text-right">
                    @if ($noOfDaysStocksAvailable > 0)
                      ({{ $noOfDaysStocksAvailable }} days)
                    @endif
                  </td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>
