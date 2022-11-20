<?php

namespace App\Http\Livewire\Collections;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\ProductCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $name;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:product_collections,name'],
        ];
    }

    public function save()
    {
        $this->validate();

        ProductCollection::create([
            'name' => strtolower($this->name),
        ]);

        $this->reset(['name', 'modal']);

        $this->notify('Collection created');

        $this->emit('updateFormData');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.collections.create');
    }
}
