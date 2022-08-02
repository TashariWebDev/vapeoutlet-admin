<?php

namespace App\Http\Livewire\Traits;

trait WithNotifications
{
    public function notify($message)
    {
        $this->dispatchBrowserEvent('notification', ['body' => $message]);
    }
}
