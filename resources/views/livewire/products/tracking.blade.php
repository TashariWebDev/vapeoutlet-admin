<div class="text-white">

    @foreach ($stocksByChannels as $stockByChannel)
        <div class="p-2 mb-4 bg-white rounded-md shadow dark:bg-slate-900">
            <div class="py-1 px-2 w-full rounded bg-slate-200 dark:bg-slate-800">
                <h2 class="font-bold uppercase dark:text-white text-slate-900">
                    {{ $stockByChannel->sales_channel?->name }}
                </h2>
            </div>
            <div class="grid grid-cols-2 p-2 lg:grid-cols-7 dark:text-white text-slate-900">
                <div>
                    <p class="text-sm font-semibold uppercase">available</p>
                    <p>{{ $stockByChannel->total_available ?? 0 }}</p>
                </div>
                <div>
                    @if ($stockByChannel->sales_channel_id == 1)
                        <p class="text-sm font-semibold uppercase">purchased</p>
                        <p>{{ $stockByChannel->total_purchased ?? 0 }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase">sold</p>
                    <p>{{ $stockByChannel->total_sold ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase">credits</p>
                    <p>{{ $stockByChannel->total_credits ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase">supplier credits</p>
                    <p>{{ $stockByChannel->total_supplier_credits ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase">adjustments</p>
                    <p>{{ $stockByChannel->total_adjustments ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase">transfers</p>
                    <p>{{ $stockByChannel->total_transfers ?? 0 }}</p>
                </div>
            </div>
        </div>
    @endforeach


    {{--     <div> --}}
    {{--         <div> --}}
    {{--             {{ $allStocks->links() }} --}}
    {{--         </div> --}}

    {{--         <div class="flow-root mt-8"> --}}
    {{--             <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8"> --}}
    {{--                 <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8"> --}}
    {{--                     <table class="min-w-full divide-y divide-slate-500 text-slate-900 dark:divide-slate-800 dark:text-slate-500"> --}}
    {{--                         <thead> --}}
    {{--                             <tr> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >ID --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >DATE --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >TYPE --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >REF --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-right whitespace-nowrap" --}}
    {{--                                 >QTY --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-right whitespace-nowrap" --}}
    {{--                                 >COST --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >DOC --}}
    {{--                                 </th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 ></th> --}}
    {{--                                 <th scope="col" --}}
    {{--                                     class="py-2.5 px-2 text-sm font-semibold text-left whitespace-nowrap" --}}
    {{--                                 >CHANNEL --}}
    {{--                                 </th> --}}
    {{--                             </tr> --}}
    {{--                         </thead> --}}
    {{--                         <tbody class="divide-y divide-slate-300 text-slate-900 dark:divide-slate-800 dark:text-slate-500"> --}}
    {{--                             @foreach($allStocks as $allStock) --}}
    {{--                                 <tr class="uppercase divide-x divide-slate-300 dark:divide-slate-800"> --}}
    {{--                                     <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->id }}</td> --}}
    {{--                                     <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->created_at }}</td> --}}
    {{--                                     <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->type }}</td> --}}
    {{--                                     <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->reference }}</td> --}}
    {{--                                     <td class="py-2 px-2 text-sm text-right whitespace-nowrap">{{ $allStock->qty }}</td> --}}
    {{--                                     <td class="py-2 px-2 text-sm text-right whitespace-nowrap">{{ $allStock->cost }}</td> --}}
    {{--                                     @if($allStock->order_id) --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"> --}}
    {{--                                             <a href="{{ route('orders/show',$allStock->order_id) }}" --}}
    {{--                                                class="link" --}}
    {{--                                             > --}}
    {{--                                                 INV00{{ $allStock->order_id }} --}}
    {{--                                             </a> --}}
    {{--                                         </td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->order->customer->name }}</td> --}}
    {{--                                     @endif --}}
    {{--                                     @if($allStock->credit_id) --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"> --}}
    {{--                                             {{ $allStock->reference }} --}}
    {{--                                              --}}{{--                                             <a href="{{ route('credits/create',$allStock->credit_id) }}"> --}}
    {{--                                              --}}{{--                                                 CR00{{ $allStock->credit_id }} --}}
    {{--                                              --}}{{--                                             </a> --}}
    {{--                                         </td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->credit->customer->name }}</td> --}}
    {{--                                     @endif --}}
    {{--                                     @if($allStock->purchase_id) --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"> --}}
    {{--                                             <a href="{{ route('purchases/edit',$allStock->purchase_id) }}" --}}
    {{--                                                class="link" --}}
    {{--                                             > --}}
    {{--                                                 {{ $allStock->reference }} --}}
    {{--                                             </a> --}}
    {{--                                         </td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->purchase->supplier->name ?? '' }}</td> --}}
    {{--                                     @endif --}}
    {{--                                     @if($allStock->supplier_credit_id) --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->supplier_credit_id}}</td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->supplier_credit->supplier->name }}</td> --}}
    {{--                                     @endif --}}
    {{--                                     @if($allStock->stock_transfer_id) --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->stock_transfer_id }}</td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"></td> --}}
    {{--                                     @endif --}}
    {{--                                     @if($allStock->type === 'adjustment') --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"> --}}
    {{--                                             <a href="{{ route('stock-takes/show',Str::after($allStock->reference,'ST00')) }}" --}}
    {{--                                                class="link" --}}
    {{--                                             > --}}
    {{--                                                 {{ $allStock->reference }} --}}
    {{--                                             </a> --}}
    {{--                                         </td> --}}
    {{--                                         <td class="py-2 px-2 text-sm whitespace-nowrap"></td> --}}
    {{--                                     @endif --}}
    {{--                                     <td class="py-2 px-2 text-sm whitespace-nowrap">{{ $allStock->sales_channel->name }}</td> --}}
    {{--                                 </tr> --}}
    {{--                             @endforeach --}}
    {{--                         </tbody> --}}
    {{--                     </table> --}}
    {{--                 </div> --}}
    {{--             </div> --}}
    {{--         </div> --}}

    {{--     </div> --}}
</div>
