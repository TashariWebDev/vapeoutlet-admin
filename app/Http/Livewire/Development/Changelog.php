<?php

namespace App\Http\Livewire\Development;

use Livewire\Component;

class Changelog extends Component
{
    public function render()
    {
        return view('livewire.development.changelog')->layout('layouts.blank');
    }
}
