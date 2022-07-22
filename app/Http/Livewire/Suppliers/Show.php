<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Supplier $supplier;

    public function mount()
    {
        $this->supplier = Supplier::find(request('id'));
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.suppliers.show');
    }
}
