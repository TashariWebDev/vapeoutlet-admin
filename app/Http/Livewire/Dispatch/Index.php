<?php

namespace App\Http\Livewire\Dispatch;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showConfirmModal = false;

    public $searchTerm = '';

    public $status = 'shipped';

    public $waybill = '';

    public $selectedOrder;

    public function rules(): array
    {
        return [
            'status' => 'required',
            'waybill' => 'sometimes|nullable',
        ];
    }

    public function pushToComplete()
    {
        $validatedData = $this->validate();
        $this->selectedOrder->update($validatedData);
        $this->showConfirmModal = ! $this->showConfirmModal;
        $this->notify('order shipped');
    }

    public function confirmToComplete(Order $order)
    {
        $this->selectedOrder = $order;
        $this->showConfirmModal = ! $this->showConfirmModal;
    }

    public function getDocument(Order $order)
    {
        Http::get(
            config('app.admin_url')."/webhook/delivery-note/{$order->id}"
        );

        $this->redirect("/dispatch?page={$this->page}");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.dispatch.index', [
            'orders' => Order::query()
                ->with('delivery', 'customer', 'customer.transactions', 'items')
                ->where('status', '=', 'packed')
                ->when($this->searchTerm, function ($query) {
                    $query->where('id', 'like', $this->searchTerm.'%')
                        ->orWhereHas('customer', function ($query) {
                            $query->where('name', 'like', $this->searchTerm.'%')
                                ->orWhere('company', 'like', $this->searchTerm.'%')
                                ->orWhere('email', 'like', $this->searchTerm.'%')
                                ->orWhere('phone', 'like', $this->searchTerm.'%');
                        });
                })
                ->latest()
                ->paginate(5),
        ]);
    }
}
