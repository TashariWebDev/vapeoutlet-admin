<?php

namespace App\Http\Livewire\Users;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Permission;
use App\Models\SalesChannel;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    use WithNotifications;

    public $user;

    protected $listeners = ['refreshData' => '$refresh'];

    public function rules(): array
    {
        return [
            'user.name' => ['required'],
            'user.email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'user.phone' => ['sometimes'],
        ];
    }

    public function mount()
    {
        $this->user = User::withTrashed()->find(request('id'));
        $this->user->load('permissions', 'sales_channels');
    }

    public function updateUser()
    {
        $this->validate();
        $this->user->save();
        $this->notify('User updated');
    }

    public function deleteUser()
    {
        $this->user->delete();
        $this->notify('User deactivated');
    }

    public function restoreUser()
    {
        $this->user->restore();
        $this->notify('User Activated');
    }

    public function assignAllPermissions()
    {
        $permissions = Permission::all()->pluck('id');

        $this->user->permissions()->sync($permissions);

        $this->notify('All permissions assigned');
    }

    public function revokeAllPermissions()
    {
        $permissions = $this->user->permissions->pluck('permission_id');

        foreach ($permissions as $permission) {
            $this->user->permissions()->detach($permission);
        }

        $this->notify('All permissions revoked');
    }

    public function addPermission($permission)
    {
        $this->user->permissions()->attach($permission);
        $this->notify('Permission assigned');
    }

    public function revokePermission($permission)
    {
        $this->user->permissions()->detach($permission);
        $this->notify('Permission revoked');
    }

    public function addSalesChannel($channel)
    {
        $this->user->sales_channels()->attach($channel);
        $this->notify('Channel attached');
    }

    public function revokeSalesChannel($channel)
    {
        $this->user->sales_channels()->detach($channel);
        $this->notify('Channel revoked');
    }

    public function setDefaultChannel($channelId)
    {
        foreach ($this->user->sales_channels as $userChannel) {
            $userChannel->pivot->is_default = false;
            $userChannel->pivot->save();
        }
        $this->user
            ->sales_channels()
            ->updateExistingPivot($channelId, ['is_default' => true]);
    }

    public function sendPasswordResetLink()
    {
        Password::sendResetLink(['email' => $this->user->email]);
        $this->notify('Password reset link sent');
    }

    public function render(): Factory|View|Application
    {
        $this->emitSelf('refreshData');

        $userPermissions = $this->user->permissions()->pluck('permission_id');

        $userSalesChannels = $this->user
            ->sales_channels()
            ->pluck('sales_channel_id');

        return view('livewire.users.show', [
            'permissions' => Permission::query()
                ->whereNotIn('id', $userPermissions)
                ->orderBy('name')
                ->get(['id', 'name']),
            'salesChannels' => SalesChannel::query()
                ->whereNotIn('id', $userSalesChannels)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
