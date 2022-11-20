<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $password = '';

    public $is_wholesale = false;

    public $modal = false;

    protected $listeners = ['newCustomer' => 'toggle'];

    public function toggle()
    {
        $this->modal = ! $this->modal;
    }

    public function mount()
    {
        $this->password = bcrypt(Str::uuid());
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'unique:customers,email'],
            'phone' => ['sometimes', 'unique:customers,phone'],
            'password' => ['required'],
            'is_wholesale' => ['sometimes'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Customer::create($validated);
        $this->modal = false;
        Password::sendResetLink(['email' => $this->email]);

        $this->reset(['name', 'email', 'phone', 'is_wholesale']);

        $this->notify('Customer has been created');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.create');
    }
}
