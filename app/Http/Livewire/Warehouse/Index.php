<?php

namespace App\Http\Livewire\Warehouse;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $searchTerm = "";

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getPickingSlip(Order $order)
    {
        $order->load("items.product.features");

        $view = view("templates.pdf.pick-list", [
            "model" => $order,
        ])->render();

        $url = storage_path("app/public/pick-lists/$order->number.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        $this->redirect("/storage/pick-lists/$order->number.pdf");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.warehouse.index", [
            "orders" => Order::query()
                ->with("delivery", "customer", "customer.transactions", "items")
                ->when(
                    $this->searchTerm,
                    fn($query) => $query->search($this->searchTerm)
                )
                ->where("status", "=", "processed")
                ->latest()
                ->paginate(5),
        ]);
    }
}
