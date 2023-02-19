<?php

namespace App\Http\Livewire\Users;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DefaultSalesChannel extends Component
{
    protected $listeners = ['refreshUser' => '$refresh'];

    public function render(): Factory|View|Application
    {
        return view('livewire.users.default-sales-channel');
    }
}
