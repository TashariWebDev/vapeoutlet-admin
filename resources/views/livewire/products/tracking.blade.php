<div class="text-white">

    @foreach ($this->stocks as $stockByChannel)
        <div class="p-2 mb-4 bg-white rounded-lg shadow dark:bg-slate-800">
            <div class="py-1 px-2 w-full rounded bg-slate-200 dark:bg-slate-700">
                <h2 class="font-bold uppercase text-slate-600 dark:text-slate-400">
                    {{ $stockByChannel->sales_channel?->name }}
                </h2>
            </div>
            <div class="grid grid-cols-2 p-2 lg:grid-cols-7 text-slate-600 dark:text-slate-400">
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
</div>
