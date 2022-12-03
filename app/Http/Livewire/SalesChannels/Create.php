<?php

namespace App\Http\Livewire\SalesChannels;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\SalesChannel;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $name;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:sales_channels,name'],
        ];
    }

    public function save()
    {
        $this->validate();

        SalesChannel::create([
            'name' => strtolower($this->name),
        ]);

        $this->reset(['name', 'modal']);

        $this->notify('SalesChannel created');

        $this->emit('updateFormData');
    }

    public function render()
    {
        return view('livewire.sales-channels.create');
    }
}
