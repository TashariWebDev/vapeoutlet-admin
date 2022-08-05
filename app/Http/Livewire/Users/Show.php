<?php

namespace App\Http\Livewire\Users;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    public $user;

    public function rules()
    {
        return [
            'user.name' => ['required'],
            'user.email' => ['required', Rule::unique('users', 'email')->ignore($this->user->id)],
            'user.phone' => ['sometimes'],
        ];
    }

    public function mount()
    {
        $this->user = User::withTrashed()->find(request('id'));
        $this->user->load('permissions');
    }

    public function updateUser()
    {
        $this->validate();
        $this->user->save();

        $this->dispatchBrowserEvent('notification', ['body' => 'User updated']);
    }

    public function deleteUser()
    {
        $this->user->delete();
        $this->dispatchBrowserEvent('notification', ['body' => 'User deactivated']);
    }

    public function restoreUser()
    {
        $this->user->restore();
        $this->dispatchBrowserEvent('notification', ['body' => 'User Activated']);
    }

    public function assignAllPermissions()
    {
        $permissions = Permission::all()->pluck('id');
        $this->user->permissions()->sync($permissions);
        $this->user->refresh();

        $this->dispatchBrowserEvent('notification', ['body' => 'All permissions assigned']);
    }

    public function revokeAllPermissions()
    {
        $permissions = $this->user->permissions()->pluck('permission_id');

        foreach ($permissions as $permission) {
            $this->user->permissions()->detach($permission);
        }
        $this->user->refresh();

        $this->dispatchBrowserEvent('notification', ['body' => 'All permissions revoked']);
    }

    public function addPermission($permission)
    {
        $this->user->permissions()->attach($permission);
        $this->user->refresh();

        $this->dispatchBrowserEvent('notification', ['body' => 'Permission assigned']);
    }

    public function revokePermission($permission)
    {
        $this->user->permissions()->detach($permission);
        $this->user->refresh();

        $this->dispatchBrowserEvent('notification', ['body' => 'Permission revoked']);
    }

    public function render(): Factory|View|Application
    {
        $userPermissions = $this->user->permissions()->pluck('permission_id');

        return view('livewire.users.show', [
            'permissions' => Permission::query()
                ->whereNotIn('id', $userPermissions)
                ->orderBy('name', 'asc')
                ->get(['id', 'name']),
        ]);
    }
}
