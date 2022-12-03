<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

class DefaultSalesChannel extends Component
{
    protected $listeners = ['refreshUser' => '$refresh'];

    public function render()
    {
        return view('livewire.users.default-sales-channel');
    }
}
