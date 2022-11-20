<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Note extends Component
{
    use WithNotifications;

    public $modal = false;

    public $body = '';

    public $is_private = true;

    public $user_id;

    public $order_id;

    public Order $order;

    public function rules(): array
    {
        return [
            'body' => ['required'],
            'is_private' => ['required'],
            'order_id' => ['required'],
            'user_id' => ['required'],
        ];
    }

    public function mount()
    {
        $this->user_id = auth()->id();
        $this->order_id = $this->order->id;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $this->order->notes()->create($validatedData);

        $this->reset(['body']);

        $this->modal = false;

        $this->notify('note added');

        $this->emit('update_order');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.note');
    }
}
