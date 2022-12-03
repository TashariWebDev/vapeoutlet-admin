<?php

namespace App\Http\Livewire\SalesChannels;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\SalesChannel;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $searchQuery;

    protected $listeners = ['updateFormData' => '$refresh'];

    public function disableShipping(SalesChannel $channel)
    {
        $channel->allows_shipping = false;
        $channel->save();

        $this->notify($channel->name.'shipping disabled');
    }

    public function enableShipping(SalesChannel $channel)
    {
        $channel->allows_shipping = true;
        $channel->save();

        $this->notify($channel->name.'shipping enabled');
    }

    public function disableChannel(SalesChannel $channel)
    {
        $channel->delete();

        $this->notify('SalesChannel disabled');
    }

    public function enableChannel($channelId)
    {
        $channel = SalesChannel::withTrashed()->find($channelId);
        $channel->restore();

        $this->notify('SalesChannel restored');
    }

    public function render()
    {
        return view('livewire.sales-channels.index', [
            'channels' => SalesChannel::query()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->where(
                        'name',
                        'like',
                        $this->searchQuery.'%'
                    )
                )
                ->withSum('stocks', 'qty')
                ->withTrashed()
                ->paginate(10),
        ]);
    }
}
