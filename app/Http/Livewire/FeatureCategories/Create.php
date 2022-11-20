<?php

namespace App\Http\Livewire\FeatureCategories;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\FeatureCategory;
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
            'name' => ['required', 'unique:feature_categories,name'],
        ];
    }

    public function save()
    {
        $this->validate();

        FeatureCategory::create([
            'name' => strtolower($this->name),
        ]);

        $this->reset(['name', 'modal']);

        $this->notify('Feature category created');

        $this->emit('updateFormData');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.feature-categories.create');
    }
}
