<?php

namespace App\Http\Livewire\Suppliers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "email" => ["required"],
            "phone" => ["required"],
            "person" => ["required"],
            "address_line_one" => ["required"],
            "address_line_two" => ["sometimes"],
            "suburb" => ["sometimes"],
            "city" => ["sometimes"],
            "country" => ["sometimes"],
            "postal_code" => ["sometimes"],
        ];
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.suppliers.edit");
    }
}
