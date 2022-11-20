<?php

namespace App\Http\Livewire\StockTakes;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\StockTake;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $searchQuery;

    public function updatedSearchQuery()
    {
        $this->resetPage();
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
