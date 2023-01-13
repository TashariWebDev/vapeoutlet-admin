<?php

namespace App\Http\Livewire\StockTakes;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Product;
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

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function getBrandsProperty(): _IH_Brand_C|Collection|array
    {
        return Brand::whereHas('products', function ($query) {
            $query->whereHas('stocks', function ($query) {
                $query->where(
                    'sales_channel_id',
                    '=',
                    auth()
                        ->user()
                        ->defaultSalesChannel()->id
                );
            });
        })->get();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(StockTake $stockTake)
    {
        $stockTake->printCountSheet();

        return redirect("/storage/stock-counts/$stockTake->number.pdf");
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStockTakeDocument(StockTake $stockTake)
    {
        $stockTake->print();

        return redirect("/storage/stock-takes/$stockTake->number.pdf");
    }

    public function delete(StockTake $stockTake)
    {
        $stockTake->delete();

        $this->notify('Stock take deleted');
    }

    public function createStockTake()
    {
        $this->validate([
            'selectedBrands' => 'required|array',
        ]);

        $this->notify('Working on it!');

        foreach ($this->selectedBrands as $brand) {
            $stockTake = StockTake::updateOrCreate(
                [
                    'brand' => $brand,
                    'sales_channel_id' => auth()
                        ->user()
                        ->defaultSalesChannel()->id,
                    'processed_at' => null,
                ],
                [
                    'brand' => $brand,
                    'created_by' => auth()->user()->name,
                    'date' => now(),
                    'sales_channel_id' => auth()
                        ->user()
                        ->defaultSalesChannel()->id,
                ]
            );

            $selectedProducts = Product::query()
                ->select('products.id', 'products.cost')
                ->where('brand', '=', $brand)
                ->whereHas('stocks', function ($query) use ($stockTake) {
                    $query->where(
                        'sales_channel_id',
                        '=',
                        $stockTake->sales_channel_id
                    );
                })
                ->get();

            foreach ($selectedProducts as $product) {
                $stockTake->items()->create([
                    'product_id' => $product->id,
                    'cost' => $product->cost,
                ]);
            }
        }

        $this->selectedBrands = [];
        $this->showStockTakeModal = false;

        $this->notify('Stock take created');
        $this->redirect('stock-takes');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.stock-takes.index', [
            'stockTakes' => StockTake::query()
                ->with(['items.product'])
                ->latest()
                ->when($this->searchQuery, function ($query) {
                    $query
                        ->where('brand', 'like', '%'.$this->searchQuery.'%')
                        ->orWhere('id', 'like', '%'.$this->searchQuery.'%');
                })
                ->paginate(8),
        ]);
    }
}
