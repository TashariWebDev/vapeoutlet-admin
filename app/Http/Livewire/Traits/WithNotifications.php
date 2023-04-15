<?php

namespace App\Http\Livewire\Traits;

trait WithNotifications
{
    public function notify($message): void
    {
        $this->dispatchBrowserEvent('notification', ['body' => $message]);
    }
}
