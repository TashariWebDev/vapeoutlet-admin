<?php

namespace App\Http\Livewire\Suppliers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $fullButton = false;

    public $modal;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $person = '';

    public $address_line_one = '';

    public $address_line_two = '';

    public $suburb = '';

    public $city = '';

    public $country = '';

    public $postal_code = '';

    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'person' => ['required'],
            'address_line_one' => ['required'],
            'address_line_two' => ['sometimes'],
            'suburb' => ['sometimes'],
            'city' => ['sometimes'],
            'country' => ['sometimes'],
            'postal_code' => ['sometimes'],
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        Supplier::create($validatedData);

        $this->reset([
            'name',
            'email',
            'phone',
            'person',
            'address_line_one',
            'address_line_two',
            'suburb',
            'city',
            'country',
            'postal_code',
        ]);

        $this->modal = false;

        $this->notify('Supplier created');

        $this->emit('supplier_updated');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.suppliers.create');
    }
}
