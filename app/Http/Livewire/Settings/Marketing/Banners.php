<?php

namespace App\Http\Livewire\Settings\Marketing;

use App\Models\MarketingBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Banners extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $showCreateBannerForm = false;
    public $image;
    public $iteration = 1;

    public function rules()
    {
        return [
            'image' => ['image', 'required']
        ];
    }

    public function save()
    {
        $this->validate();
        MarketingBanner::create([
            'image' => $this->image->store('banners', 'public')
        ]);
        $this->showCreateBannerForm = false;
        $this->iteration++;

        $this->dispatchBrowserEvent('notification', 'Banner saved');
    }

    public function delete(MarketingBanner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        $this->dispatchBrowserEvent('notification', 'Banner deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.marketing.banners', [
            'banners' => MarketingBanner::simplePaginate(1)
        ]);
    }
}
