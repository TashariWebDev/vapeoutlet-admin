<?php

namespace App\Http\Livewire\StockTakes;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Stock;
use App\Models\StockTake;
use App\Models\StockTakeItem;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    use WithNotifications;

    public $showConfirmModal;

    public $stockTakeId;

    public $count;

    public function mount(): void
    {
        $this->stockTakeId = request('id');
    }

    public function updateItem(StockTakeItem $item, $count): void
    {
        if ($count == '' || $count < 0) {
            $item->update([
                'count' => null,
                'variance' => 0,
            ]);

            $this->notify('item will be excluded from count');

            return;
        }

        $item->update([
            'count' => $count,
            'variance' => $count -
                $item->product->fresh()->stocks
                    ->where(
                        'sales_channel_id',
                        '=',
                        $item->stockTake->sales_channel_id
                    )
                    ->sum('qty'),
        ]);

        $this->notify('updated');
    }

    public function process(): void
    {
        $this->notify('processing');

        DB::transaction(function () {
            $stockTake = StockTake::find($this->stockTakeId)->load(
                'items.product'
            );

            foreach ($stockTake->items as $item) {
                if ($item->variance != 0) {
                    Stock::create([
                        'product_id' => $item->product->id,
                        'type' => 'adjustment',
                        'reference' => 'ST00'.$stockTake->id,
                        'qty' => $item->variance,
                        'cost' => $item->product->cost,
                        'sales_channel_id' => $stockTake->sales_channel_id,
                    ]);
                }
            }

            $stockTake->update([
                'processed_at' => now(),
                'processed_by' => auth()->user()->name,
            ]);
        });
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.stock-takes.show', [
            'stockTake' => StockTake::with('items.product.features')
                ->where('id', '=', $this->stockTakeId)
                ->first(),
        ]);
    }
}
