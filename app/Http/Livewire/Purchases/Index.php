<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Purchase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): Factory|View|Application
    {
        return view('livewire.purchases.index', [
            'purchases' => Purchase::query()
                ->with(['items', 'supplier'])
                ->simplePaginate()
        ]);
    }
}
