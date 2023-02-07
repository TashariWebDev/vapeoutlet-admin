<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $customer;

    protected $listeners = ['refresh_data' => '$refresh'];

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
            'customer.name' => ['required'],
            'customer.email' => [
                'required',
                Rule::unique('customers', 'email')->ignore($this->customer->id),
            ],
            'customer.phone' => [
                'required',
                Rule::unique('customers', 'phone')->ignore($this->customer->id),
            ],
            'customer.company' => ['nullable'],
            'customer.vat_number' => ['nullable'],
            'customer.is_wholesale' => ['sometimes'],
            'customer.salesperson_id' => ['sometimes'],
        ];
    }

    public function mount()
    {
        $this->customer = Customer::with('addresses')
            ->where('id', request('id'))
            ->firstOrFail();
    }

    public function save()
    {
        $this->validate();

        $this->customer->save();

        $this->notify($this->customer->name."'s details have been updated");

        if ($this->customer->salesperson_id == 0) {
            $this->customer->update([
                'salesperson_id' => null,
            ]);
        }

        $this->emitSelf('refresh_customer');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.edit', [
            'salespeople' => User::query()
                ->where('is_super_admin', false)
                ->get(),
        ]);
    }
}
