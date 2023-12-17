<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta
      name="viewport"
      content="width=device-width, initial-scale=1"
  >
  <title>{{ ucwords(str_replace('Admin','',config('app.name'))) }} Stock Transfer</title>
  <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
      rel="stylesheet"
  >
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
      @media print {

          /*section,*/
          /*td,*/
          /*tr,*/
          /*div,*/
          section {
              page-break-inside: avoid !important;
          }

          @page {
              margin-top: 3mm;
              margin-bottom: 0;
              size: legal portrait;
          }

          @page :first {
              margin-top: 3mm;
              margin-bottom: 0;
              size: legal portrait;
          }
      }
  </style>
</head>

<body>
  <div class="w-screen font-sans antialiased bg-white">
    <div class="p-6 bg-white rounded">
      <section
          class="pb-4"
          id="header"
      >
        <div class="grid grid-cols-2 border-b">
          <x-document.company />
          <div class="font-mono text-xs text-right">
            <ul>
              <li>{{ $transfer->date->format('Y-m-d') }}</li>
              <li class="capitalize">{{ $transfer->number() }}</li>
              <li class="capitalize">{{ $transfer->user->name }}</li>
              <li class="text-lg font-extrabold uppercase">
                from {{ $transfer->dispatcher->name }} to {{ $transfer->receiver->name }}
              </li>
            </ul>
          </div>
          <div class="pt-6">
            <p>CHECKED BY: ......................................................</p>
          </div>
        </div>
      </section>
      
      <div id="body">
        
        <table class="w-full">
          <thead class="text-sm font-bold text-white uppercase bg-gray-900">
            <tr>
              <th class="text-left">SKU/CODE</th>
              <th class="col-span-2 text-left">Item</th>
              <th class="text-right">Qty</th>
              <th class="text-right">Count</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transfer->items as $item)
              <tr class="border-b border-dashed">
                <td class="text-left">
                  <p class="text-xs font-semibold uppercase">{{ $item->product->sku }}</p>
                </td>
                <td class="col-span-2 text-left">
                  <div>
                    <p class="font-bold tracking-tight leading-tight uppercase text-[10px]">
                      {{ $item->product->brand }} {{ $item->product->name }}   {{ $item->product->category }}
                    </p>
                    <ul class="flex flex-wrap leading-tight text-gray-800">
                      @foreach ($item->product->features as $feature)
                        <li class="pr-1 tracking-wide text-[8px]"> {{ $feature->name }}</li>
                      @endforeach
                    </ul>
                  </div>
                </td>
                <td class="text-right">
                  <p class="font-mono text-xs">{{ $item->qty }}</p>
                </td>
                <td class="flex justify-end py-1 text-right">
                  <div
                      class="flex justify-center items-center p-1 w-6 h-6 font-bold text-gray-100 border"
                  >
                    X
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    
    </div>
  </div>
</body>

</html>
