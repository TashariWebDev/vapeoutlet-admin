<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showAddOrderForm = false;

    public $searchTerm = '';

    public $filter = 'received';

    public function getDocument($transactionId)
    {
        Log::info($transactionId);
        Http::get(
            config('app.admin_url') . "/webhook/save-document/{$transactionId}"
        );

        $this->redirect("orders?page={$this->page}");
    }

    public function mount()
    {
        if (request()->has('filter')) {
            $this->filter = request('filter');
        }
    }

    public function render()
    {
        return view('livewire.orders.index', [
            'orders' => Order::query()
                ->with('delivery', 'customer', 'customer.transactions', 'items')
                ->whereNotNull('status')
                ->when($this->searchTerm, function ($query) {
                    $query->where('id', 'like', $this->searchTerm . '%')
                        ->orWhere('status', 'like', $this->searchTerm . '%')
                        ->orWhereHas('customer', function ($query) {
                            $query->where('name', 'like', $this->searchTerm . '%')
                                ->orWhere('company', 'like', $this->searchTerm . '%')
                                ->orWhere('email', 'like', $this->searchTerm . '%')
                                ->orWhere('phone', 'like', $this->searchTerm . '%');
                        });
                })
                ->when($this->filter, function ($query) {
                    $query->whereStatus($this->filter);
                })
                ->latest()
                ->paginate(5),
        ]);
    }
}
