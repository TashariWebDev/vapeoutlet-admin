<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Purchase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Pending extends Component
{
    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.purchases.pending', [
            'purchases' => Purchase::query()
                ->with('supplier')
                ->whereNull('processed_date')
                ->get(),
        ]);
    }
}
