<?php

namespace App\Http\Livewire\Settings\Brands\Forms;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public $showBrandsForm = false;

    public $brandName;

    public $brandLogo;

    protected $listeners = ['showDaBrandsForm' => 'showDaBrandsForm'];

    public function showDaBrandsForm()
    {
        $this->showBrandsForm = true;
    }

    public function addBrand()
    {
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.brands.forms.create');
    }
}
