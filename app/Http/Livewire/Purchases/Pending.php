<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;

class Pending extends Component
{
    public function render()
    {
        return view('livewire.purchases.pending', [
            'purchases' => Purchase::query()
                ->whereNull('processed_date')
                ->get(),
        ]);
    }
}
