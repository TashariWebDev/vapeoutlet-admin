<?php

namespace App\Http\Livewire\Outlets;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Outlet;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $name;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:outlets,name'],
        ];
    }

    public function save()
    {
        $this->validate();

        Outlet::create([
            'name' => strtolower($this->name),
        ]);

        $this->reset(['name', 'modal']);

        $this->notify('Outlet created');

        $this->emit('updateFormData');
    }

    public function render()
    {
        return view('livewire.outlets.create');
    }
}
