<?php

namespace App\Http\Livewire\Settings\Marketing;

use App\Http\Livewire\Traits\WithNotifications;
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
    use WithNotifications;

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
        $this->notify('Banner saved');
    }

    public function updateOrder($bannerId, $orderNumber)
    {
        $banner = MarketingBanner::find($bannerId);
        $banner->update(['order' => $orderNumber]);
        $this->notify('Banner order updated');
    }

    public function delete(MarketingBanner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        $this->notify('Banner deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.marketing.banners', [
            'banners' => MarketingBanner::orderBy('order', 'asc')->simplePaginate(1)
        ]);
    }
}
