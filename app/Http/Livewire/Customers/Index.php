<?php

namespace App\Http\Livewire\Customers;

use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchQuery;

    public $recordCount = 10;

    protected $queryString = ['recordCount', 'searchQuery'];

    public function mount()
    {
        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }

        foreach (Customer::query()->get() as $customer) {
            UpdateCustomerRunningBalanceJob::dispatch($customer->id);
        }
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.index', [
            'customers' => Customer::query()
                ->with('latestTransaction')
                ->with('salesperson:id,name')
                ->withTrashed()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->orderBy('name')
                ->paginate($this->recordCount),
        ]);
    }
}
