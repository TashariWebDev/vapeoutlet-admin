<?php

namespace App\Http\Livewire\Address;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\CustomerAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $province;

    public $line_one;

    public $line_two;

    public $suburb;

    public $city;

    public $postal_code;

    public $customer_id;

    public $provinces = [
        'gauteng',
        'kwazulu natal',
        'limpopo',
        'mpumalanga',
        'north west',
        'free state',
        'northern cape',
        'western cape',
        'eastern cape',
    ];

    public function rules(): array
    {
        return [
            'line_one' => 'required',
            'line_two' => 'sometimes',
            'suburb' => 'sometimes',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'customer_id' => 'required',
        ];
    }

    public function mount($customerId)
    {
        $this->customer_id = $customerId;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $address = CustomerAddress::create($validatedData);

        $this->notify($address->customer->name."'s Address has been updated");

        $this->modal = false;

        $this->reset([
            'province',
            'line_one',
            'line_two',
            'suburb',
            'city',
            'postal_code',
        ]);

        $this->emit('refresh_data');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.address.create');
    }
}
