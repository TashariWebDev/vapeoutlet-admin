<?php

namespace App\Http\Livewire\Customers;

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
