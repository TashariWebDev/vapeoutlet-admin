<?php

namespace App\Http\Livewire\Reports;

use App\Models\Credit;
use App\Models\User;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class CreditReport extends Component
{
    public $showCreditsForm = false;

    public $admins = [];

    public $selectedAdmin;

    public $fromDate;

    public $toDate;

    public function mount()
    {
        $this->admins = User::all();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $credits = Credit::whereBetween('created_at', [
            $this->fromDate,
            $this->toDate,
        ])
            ->when($this->selectedAdmin, function ($query) {
                $query->whereCreatedBy($this->selectedAdmin);
            })
            ->get()
            ->groupBy('created_by');

        $view = view('templates.pdf.credits-report', [
            'credits' => $credits,
            'from' => $this->fromDate,
            'to' => $this->toDate,
        ])->render();

        $url = storage_path('app/public/documents/credits-report.pdf');

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect('/storage/documents/credits-report.pdf');
    }

    public function render()
    {
        return view('livewire.reports.credit-report');
    }
}
