<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta
      name="viewport"
      content="width=device-width, initial-scale=1"
  >
  <title></title>
  <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
      rel="stylesheet"
  >
  <link
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"
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

<body class="relative">
  
  <div class="overflow-hidden relative z-50 w-screen font-sans antialiased bg-white">
    <div class="flex z-50 flex-col p-6 min-h-screen bg-white rounded">
      <section
          class="pb-4"
          id="header"
      >
        <div class="grid grid-cols-2 border-b">
          <x-document.company />
          <div class="font-mono text-right text-[10px]">
            <ul>
              <li>{{ $stockTake->created_at }}</li>
              <li class="capitalize text-[10px]">STOCK TAKE ID:{{ $stockTake->id }}</li>
              <li class="capitalize text-[10px]">{{ $stockTake->sales_channel->name }}</li>
              <li class="font-extrabold uppercase text-[10px]">{{ $stockTake->created_by }}</li>
            </ul>
          </div>
          <div class="pt-6 text-[10px]">
            <p>COUNTED BY: ......................................................</p>
          </div>
        </div>
      </section>
      
      <div
          class="break-before-avoid-page"
          id="body"
      >
        <div class="grid grid-cols-6 w-full break-inside-avoid">
          <div class="col-span-2 px-1 text-xs text-left text-white uppercase bg-gray-700 border">
            SKU/CODE
          </div>
          <div class="col-span-3 px-1 text-xs text-left text-white uppercase bg-gray-700 border">
            Item
          </div>
          <div class="col-span-1 px-1 text-xs text-right text-white uppercase bg-gray-700 border">
            Count
          </div>
        </div>
        
        <div class="block break-before-avoid break-after-avoid">
          @foreach ($stockTake->items as $item)
            <div class="grid grid-cols-6 w-full border-b break-after-avoid-page">
              <div class="col-span-2">
                <p class="font-semibold uppercase text-[10px]">{{ $item->product->sku }}</p>
              </div>
              <div class="col-span-3">
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
              </div>
              <div class="flex col-span-1 justify-end items-center">
                <div class="flex justify-center items-center w-8 h-8 text-lg rounded-md border border-black">
                  <p class="font-extrabold text-gray-100">X</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      
      </div>
    </div>
  </div>
</body>

</html>
