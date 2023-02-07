<?php

namespace App\Http\Livewire\StockTakes;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.stock-takes.create');
    }
}
