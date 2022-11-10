<?php

namespace App\Http\Livewire\Components;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class QuickCustomer extends Component
{
    use WithNotifications;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $password = '';

    public $is_wholesale = false;

    public $customerModal = false;

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
        $this->customerModal = false;
        Password::sendResetLink(['email' => $this->email]);

        $this->reset(['name', 'email', 'phone', 'is_wholesale']);

        $this->notify('Customer has been created');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.quick-customer');
    }
}
