<?php

namespace App\View\Components\Document;

use App\Models\SystemSetting;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Banking extends Component
{
    public SystemSetting $company;

    public string $reference;

    protected function __construct($reference)
    {
        $this->company = SystemSetting::first();
        $this->reference = $reference;
    }

    public function render(): View
    {
        return view('components.document.banking');
    }
}
