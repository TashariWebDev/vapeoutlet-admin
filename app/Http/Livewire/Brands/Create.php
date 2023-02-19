<?php

namespace App\Http\Livewire\Brands;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use WithNotifications;

    public $modal = false;

    public $name;

    public $logo;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:brands,name'],
            'logo' => ['required', 'max:1024'],
        ];
    }

    public function save()
    {
        $this->validate();

        Brand::create([
            'name' => strtolower($this->name),
            'image' => $this->logo->store(
                'uploads/'.config('app.storage_folder'),
                'public'
            ),
        ]);

        $this->reset(['name', 'logo', 'modal']);

        $this->notify('Brand created');

        $this->emit('updateFormData');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.brands.create');
    }
}
