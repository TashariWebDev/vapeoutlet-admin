<?php

namespace App\Http\Livewire\Users;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SalesChannelChangeButton extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.users.sales-channel-change-button');
    }
}
