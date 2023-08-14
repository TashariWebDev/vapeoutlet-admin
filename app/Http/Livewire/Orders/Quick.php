<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Livewire\WithPagination;

class Quick extends Component
{
    use WithPagination;

    public $modal = false;

    public $searchQuery;

    public Customer $selectedCustomer;

    protected $queryString = ['searchQuery'];

    protected $listeners = ['newOrder' => 'toggle'];

    public function toggle(): void
    {
        $this->modal = true;
    }

    public function mount(): void
    {
        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }
    }

    public function selectedCustomer($customerId): void
    {
        $this->selectedCustomer = Customer::where('id', $customerId)->first();
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function createOrder($customerId): Redirector|Application|RedirectResponse
    {
        $order = Order::firstOrCreate([
            'customer_id' => $customerId,
            'status' => null,
            'processed_by' => auth()->user()->name,
        ]);

        $order->update([
            'created_at' => now(),
            'sales_channel_id' => auth()
                ->user()
                ->defaultSalesChannel()->id,
        ]);

        return redirect("/orders/create/$order->id");
    }

    public function render(): Factory|View|Application
    {
        $customers = Customer::query()
            ->when(
                $this->searchQuery,
                fn ($query) => $query->search($this->searchQuery)
            )
            ->orderBy('name');

        return view('livewire.orders.quick', [
            'customers' => $customers->simplePaginate(5),
            'selectedCustomer' => $customers->first(),
        ]);
    }
}
