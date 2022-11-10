<?php

namespace App\Http\Livewire\Returns;

use App\Models\SupplierCredit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public $credit;

    public function mount()
    {
        $this->credit = SupplierCredit::find(request('id'));
        $this->credit->load('items.product');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.returns.show');
    }
}
