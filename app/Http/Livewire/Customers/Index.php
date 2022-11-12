<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchQuery;

    public $recordCount = 10;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $password = '';

    public $is_wholesale = false;

    public $showCreateCustomerForm = false;

    public function mount()
    {
        $this->password = bcrypt(Str::uuid());
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
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
        $this->showCreateCustomerForm = false;
        Password::sendResetLink(['email' => $this->email]);

        $this->reset(['name', 'email', 'phone', 'is_wholesale']);

        $this->dispatchBrowserEvent('notification', [
            'body' => 'Customer has been created',
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.index', [
            'customers' => Customer::query()
                ->with('latestTransaction')
                ->withTrashed()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->orderBy('name')
                ->paginate($this->recordCount),
        ]);
    }
}
