<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $showAddressForm = false;

    public $customer;

    public $name;

    public $email;

    public $phone;

    public $company;

    public $vat_number;

    public $is_wholesale;

    public $province;

    public $line_one;

    public $line_two;

    public $suburb;

    public $city;

    public $postal_code;

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

    public function mount()
    {
        $this->customer = Customer::find(request('id'));
        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->phone = $this->customer->phone;
        $this->company = $this->customer->company;
        $this->vat_number = $this->customer->vat_number;
        $this->is_wholesale = $this->customer->is_wholesale;
    }

    public function updatedShowAddressForm()
    {
        if ($this->showAddressForm = true) {
            $this->address = new CustomerAddress();
        }
    }

    public function updateUser()
    {
        $validatedData = $this->validate([
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique('customers', 'email')->ignore($this->customer->id),
            ],
            'phone' => [
                'required',
                Rule::unique('customers', 'phone')->ignore($this->customer->id),
            ],
            'company' => ['nullable'],
            'vat_number' => ['nullable'],
            'is_wholesale' => ['sometimes'],
        ]);
//        dd($d);

        $this->customer->update($validatedData);

        if ($this->customer->wasChanged()) {
            $this->notify('Customer details have been updated');
        }
    }

    public function addAddress()
    {
        $validatedData = $this->validate([
            'province' => ['required'],
            'line_one' => ['required'],
            'line_two' => ['nullable'],
            'suburb' => ['nullable'],
            'city' => ['required'],
            'postal_code' => ['required'],
        ]);

        $this->customer->addresses()->create($validatedData);

        $this->showAddressForm = false;

        $this->reset([
            'province',
            'line_one',
            'line_two',
            'suburb',
            'city',
            'postal_code',
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.edit');
    }
}
