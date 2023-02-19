<?php

namespace App\Http\Livewire\Orders;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuickToggleButton extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.orders.quick-toggle-button');
    }
}
