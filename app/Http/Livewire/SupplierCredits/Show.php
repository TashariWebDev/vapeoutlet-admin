<?php

namespace App\Http\Livewire\SupplierCredits;

use App\Models\SupplierCredit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public $credit;

    public function mount(): void
    {
        $this->credit = SupplierCredit::find(request('id'));

        $this->credit->load('items.product');
    }

    public function print(): void
    {
        $this->credit->print();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.supplier-credits.show');
    }
}
