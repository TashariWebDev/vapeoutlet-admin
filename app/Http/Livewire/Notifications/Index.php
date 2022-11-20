<?php

namespace App\Http\Livewire\Notifications;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\MarketingNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    use WithNotifications;

    public $slide = false;

    public $body = '';

    public function rules()
    {
        return [
            'body' => ['required', 'max:50'],
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        MarketingNotification::create($validatedData);

        $this->reset(['body']);

        $this->showCreateNotificationForm = false;

        $this->notify('Notification created');
    }

    public function delete(MarketingNotification $notification)
    {
        $notification->delete();

        $this->notify('Notification deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.notifications.index', [
            'notifications' => MarketingNotification::latest()->paginate(5),
        ]);
    }
}
