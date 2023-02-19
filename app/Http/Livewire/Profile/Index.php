<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.profile.index');
    }
}
