<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchQuery = '';

    public function render(): Factory|View|Application
    {
        return view('livewire.supplier.index', [
            'suppliers' => Supplier::query()
                ->when($this->searchQuery, fn ($query) => $query->search($this->searchQuery))
                ->simplePaginate(),
        ]);
    }
}
