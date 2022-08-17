<?php

namespace App\Http\Livewire\Suppliers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $supplier;

    public function mount()
    {
        $this->supplier = Supplier::find(request("id"));
    }

    public function rules(): array
    {
        return [
            "supplier.name" => ["required"],
            "supplier.email" => ["required"],
            "supplier.phone" => ["required"],
            "supplier.person" => ["required"],
            "supplier.address_line_one" => ["required"],
            "supplier.address_line_two" => ["sometimes"],
            "supplier.suburb" => ["sometimes"],
            "supplier.city" => ["sometimes"],
            "supplier.country" => ["sometimes"],
            "supplier.postal_code" => ["sometimes"],
        ];
    }

    public function editSupplier()
    {
        $this->validate();
        $this->supplier->save();
        $this->notify("supplier updated");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.suppliers.edit");
    }
}
