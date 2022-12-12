<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

class SalesChannelChange extends Component
{
    public $modal;

    protected $listeners = ['changeSalesChannel' => 'toggle'];

    public function toggle()
    {
        $this->modal = ! $this->modal;
    }

    public function setDefaultChannel($channelId)
    {
        foreach (auth()->user()->sales_channels as $userChannel) {
            $userChannel->pivot->is_default = false;
            $userChannel->pivot->save();
        }
        auth()
            ->user()
            ->sales_channels()
            ->updateExistingPivot($channelId, ['is_default' => true]);

        $this->emit('refreshUser');
    }

    public function render()
    {
        return view('livewire.users.sales-channel-change', [
            'salesChannels' => auth()->user()->sales_channels,
        ]);
    }
}
