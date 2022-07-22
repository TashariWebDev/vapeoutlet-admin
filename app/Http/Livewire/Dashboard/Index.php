<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.dashboard.index');
    }
}
