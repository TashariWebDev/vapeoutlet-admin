<?php

namespace App\Http\Livewire\Address;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\CustomerAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $modal = false;

    public $address;

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
            'address.line_one' => 'required',
            'address.line_two' => 'sometimes',
            'address.suburb' => 'sometimes',
            'address.city' => 'required',
            'address.province' => 'required',
            'address.postal_code' => 'required',
            'address.customer_id' => 'required',
        ];
    }

    public function mount($addressId)
    {
        $this->address = CustomerAddress::findOrFail($addressId);
    }

    public function update()
    {
        $this->validate();

        $this->address->save();

        $this->notify('address updated');

        $this->modal = false;

        $this->emit('refresh_customer');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.address.edit');
    }
}
