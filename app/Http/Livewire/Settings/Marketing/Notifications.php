<?php

namespace App\Http\Livewire\Settings\Marketing;

use App\Models\MarketingNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Notifications extends Component
{
    public $showCreateNotificationForm = false;

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
        $this->dispatchBrowserEvent('notification', ['body' => 'Notification created']);
    }

    public function delete(MarketingNotification $notification)
    {
        $notification->delete();
        $this->dispatchBrowserEvent('notification', ['body' => 'Notification deleted']);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.marketing.notifications', [
            'notifications' => MarketingNotification::latest()->get(),
        ]);
    }
}
