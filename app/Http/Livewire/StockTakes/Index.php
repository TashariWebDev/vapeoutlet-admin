<?php

namespace App\Http\Livewire\StockTakes;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SalesChannel;
use App\Models\StockTake;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Brand_C;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $showStockTakeModal = false;

    public $searchQuery;

    public $selectedBrands = [];

    public $salesChannelId = 1;

    public bool $isProcessed = false;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function selectAllBrands()
    {
        $this->selectedBrands = $this->brands->pluck('name');
    }

    public function getBrandsProperty(): _IH_Brand_C|Collection|array
    {
        return Brand::orderBy('name')->get();
    }

    public function getSalesChannelsProperty(): _IH_Brand_C|Collection|array
    {
        return SalesChannel::all();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(StockTake $stockTake): void
    {
        $stockTake->printCountSheet();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStockTakeDocument(StockTake $stockTake): void
    {
        $stockTake->print();
    }

    public function delete(StockTake $stockTake): void
    {
        $stockTake->items()->delete();
        $stockTake->delete();

        $this->notify('Stock take deleted');
    }

    public function createStockTake()
    {
        $this->validate([
            'selectedBrands' => 'required|array',
            'salesChannelId' => 'required|int',
        ]);

        $this->notify('Working on it!');

        foreach ($this->selectedBrands as $brand) {
            $stockTake = StockTake::updateOrCreate(
                [
                    'brand' => $brand,
                    'sales_channel_id' => $this->salesChannelId,
                    'processed_at' => null,
                ],
                [
                    'brand' => $brand,
                    'created_by' => auth()->user()->name,
                    'date' => now(),
                    'sales_channel_id' => $this->salesChannelId,
                ]
            );

            $selectedProducts = Product::query()
                ->select('id', 'cost', 'brand')
                ->where('brand', '=', $brand)
                ->whereHas('stocks', function ($query) {
                    $query->where(
                        'sales_channel_id',
                        '=',
                        $this->salesChannelId
                    );
                })
                ->get();

            foreach ($selectedProducts as $product) {
                $stockTake->items()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                    ],
                    [
                        'product_id' => $product->id,
                        'cost' => $product->cost,
                    ]
                );
            }
        }

        $this->reset(['searchQuery', 'salesChannels', 'showStockTakeModal']);

        $this->notify('Stock take created');

        return redirect('stock-takes');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.stock-takes.index', [
            'stockTakes' => StockTake::query()
                ->with(['items.product'])
                ->latest()
                ->when($this->isProcessed === true, function ($query) {
                    $query->where('processed_at', '!=', null);
                })
                ->when($this->isProcessed === false, function ($query) {
                    $query->where('processed_at', '=', null);
                })
                ->when($this->searchQuery, function ($query) {
                    $query
                        ->where('brand', 'like', '%'.$this->searchQuery.'%')
                        ->orWhere('id', 'like', '%'.$this->searchQuery.'%')
                        ->when($this->isProcessed === true, function ($query) {
                            $query->where('processed_at', '!=', null);
                        })
                        ->when($this->isProcessed === false, function ($query) {
                            $query->where('processed_at', '=', null);
                        });
                })
                ->paginate(8),
        ]);
    }
}
