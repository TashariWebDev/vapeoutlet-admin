<?php

namespace App\View\Components\Document;

use App\Models\SystemSetting;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Company extends Component
{
    public SystemSetting $company;

    protected function __construct()
    {
        $this->company = SystemSetting::first();
    }

    public function render(): View
    {
        return view('components.document.company');
    }
}
