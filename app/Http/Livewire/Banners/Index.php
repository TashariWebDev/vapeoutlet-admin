<?php

namespace App\Http\Livewire\Banners;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\MarketingBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    use WithNotifications;

    public $slide = false;

    public $image;

    public $iteration = 1;

    public function rules()
    {
        return [
            'image' => ['image', 'required'],
        ];
    }

    public function save()
    {
        $this->validate();

        MarketingBanner::create([
            'image' => $this->image->store('uploads', 'public'),
        ]);

        $this->slide = false;

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
        return view('livewire.banners.index', [
            'banners' => MarketingBanner::query()
                ->orderBy('order')
                ->paginate(3),
        ]);
    }
}
