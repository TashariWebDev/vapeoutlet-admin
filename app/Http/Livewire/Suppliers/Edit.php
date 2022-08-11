<?php

namespace App\Http\Livewire\Suppliers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public function render(): Factory|View|Application
    {
        return view("livewire.suppliers.edit");
    }
}
