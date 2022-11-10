<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $showAddressForm = false;

    public $updateAddressForm = false;

    public $customer;

    public $address;

    public $name;

    public $email;

    public $phone;

    public $company;

    public $vat_number;

    public $is_wholesale;

    public $salesperson_id = null;

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

    public function rules(): array
    {
        return [
            'line_one' => 'required',
            'line_two' => 'sometimes',
            'suburb' => 'sometimes',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ];
    }

    public function mount()
    {
        $this->customer = Customer::find(request('id'))->load('addresses');
        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->phone = $this->customer->phone;
        $this->company = $this->customer->company;
        $this->vat_number = $this->customer->vat_number;
        $this->is_wholesale = $this->customer->is_wholesale;
        $this->salesperson_id = $this->customer->salesperson_id;
    }

    public function updatedShowAddressForm()
    {
        if ($this->showAddressForm = true) {
            $this->address = new CustomerAddress();
        }
    }

    public function editAddress($addressId)
    {
        $this->address = CustomerAddress::findOrFail($addressId);
        $this->line_one = $this->address->line_one;
        $this->line_two = $this->address->line_two;
        $this->suburb = $this->address->suburb;
        $this->city = $this->address->city;
        $this->province = $this->address->province;
        $this->postal_code = $this->address->postal_code;

        $this->updateAddressForm = true;
    }

    public function updateAddress()
    {
        $validatedData = $this->validate();

        $this->address->update($validatedData);

        $this->updateAddressForm = false;

        $this->reset([
            'line_one',
            'line_two',
            'suburb',
            'city',
            'province',
            'postal_code',
        ]);

        $this->customer->refresh();

        $this->notify('Address updated');
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
            'salesperson_id' => ['sometimes'],
        ]);

        $this->customer->update($validatedData);

        if ($this->customer->salesperson_id == 0) {
            $this->customer->update([
                'salesperson_id' => null,
            ]);
        }

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
        return view('livewire.customers.edit', [
            'salespeople' => User::query()
                ->where('email', '!=', 'ridwan@tashari.co.za')
                ->get(),
        ]);
    }
}
