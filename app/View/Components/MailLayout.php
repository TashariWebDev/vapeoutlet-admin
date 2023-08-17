<?php

namespace App\View\Components;

use App\Models\MarketingBanner;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MailLayout extends Component
{
    public function render(): View
    {
        $banner = MarketingBanner::inRandomOrder()->take(1)->value('image');
        $bannerUrl = 'https://www.admin.vapeoutlet.co.za/storage/'.$banner;

        return view('layouts.mail', [
            'bannerUrl' => $bannerUrl,
        ]);
    }
}
