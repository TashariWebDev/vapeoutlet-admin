<?php

namespace App\Http\Livewire\StockTakes;

use App\Models\StockTake;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function getDocument($stockTakeId)
    {
        Http::get(
            config("app.admin_url") . "/webhook/stock-counts/{$stockTakeId}"
        );

        $this->redirect("stock-takes?page={$this->page}");
    }

    public function getStockTakeDocument($stockTakeId)
    {
        Http::get(
            config("app.admin_url") . "/webhook/stock-takes/{$stockTakeId}"
        );

        $this->redirect("stock-takes?page={$this->page}");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.stock-takes.index", [
            "stockTakes" => StockTake::query()
                ->with(["items.product"])
                ->latest()
                ->paginate(8),
        ]);
    }
}
