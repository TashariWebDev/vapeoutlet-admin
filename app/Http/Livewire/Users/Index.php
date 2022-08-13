<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
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

    public $name = '';

    public $email = '';

    public $phone = '';

    public $password = '';

    public $showCreateUserForm = false;

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
            'email' => ['required', 'unique:users,email'],
            'phone' => ['sometimes'],
            'password' => ['required'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        User::create($validated);
        $this->showCreateUserForm = false;
        Password::sendResetLink(['email' => $this->email]);

        $this->reset(['name', 'email', 'phone']);

        $this->dispatchBrowserEvent('notification', [
            'body' => 'User has been created',
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.users.index', [
            'users' => User::query()
                ->where('email', '!=', 'ridwan@tashari.co.za')
                ->withTrashed()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->simplePaginate(15),
        ]);
    }
}
