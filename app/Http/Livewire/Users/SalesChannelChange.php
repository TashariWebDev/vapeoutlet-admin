<?php

namespace App\Http\Livewire\Users;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SalesChannelChange extends Component
{
    public $modal;

    protected $listeners = ['changeSalesChannel' => 'toggle'];

    public function toggle(): void
    {
        $this->modal = ! $this->modal;
    }

    public function getSalesChannelsProperty()
    {
        return auth()->user()
            ->sales_channels;
    }

    public function setDefaultChannel($channelId)
    {
        foreach ($this->salesChannels as $userChannel) {
            $userChannel->pivot->is_default = false;
            $userChannel->pivot->save();
        }

        auth()->user()
            ->sales_channels()
            ->updateExistingPivot($channelId, ['is_default' => true]);

        $this->toggle();

        $this->emit('refreshUser');

        return redirect()->route('dashboard');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.users.sales-channel-change');
    }
}
