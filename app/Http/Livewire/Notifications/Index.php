<?php

namespace App\Http\Livewire\Notifications;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\MarketingNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $slide = false;

    public $body = '';

    public function rules(): array
    {
        return [
            'body' => ['required', 'max:100'],
        ];
    }

    public function save(): void
    {
        $validatedData = $this->validate();

        MarketingNotification::create($validatedData);

        $this->reset(['body']);

        $this->slide = false;

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
