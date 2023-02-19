<?php

namespace App\Http\Livewire\Products;

use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Stock_C;
use Livewire\Component;

class Tracking extends Component
{
    public $productId;

    public function mount()
    {
        $this->productId = request('id');
    }

    public function getStocksProperty(): Collection|array|_IH_Stock_C
    {
        return Stock::query()
            ->where('product_id', $this->productId)
            ->with('sales_channel', function ($query) {
                $query->withTrashed();
            })
            ->select('*')
            ->groupBy('sales_channel_id')
            ->selectRaw('sum(qty) as total_available')
            ->selectRaw(
                "sum(case when type = 'purchase' then qty end) as total_purchased"
            )
            ->selectRaw(
                "sum(case when type = 'invoice' then qty end) as total_sold"
            )
            ->selectRaw(
                "sum(case when type = 'credit' then qty end) as total_credits"
            )
            ->selectRaw(
                "sum(case when type = 'supplier_credit' then qty end) as total_supplier_credits"
            )
            ->selectRaw(
                "sum(case when type = 'transfer' then qty end) as total_transfers"
            )
            ->selectRaw(
                "sum(case when type = 'adjustment' then qty end) as total_adjustments"
            )
            ->get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.tracking');
    }
}
