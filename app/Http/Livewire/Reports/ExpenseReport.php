<?php

namespace App\Http\Livewire\Reports;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class ExpenseReport extends Component
{
    public $showExpenseForm = false;

    public $fromDate;

    public $toDate;

    public $category;

    public $categories;

    public function mount()
    {
        $this->categories = ExpenseCategory::all();
    }

    public function print(): Redirector|Application|RedirectResponse
    {
        $expenses = Expense::whereBetween('date', [
            $this->fromDate,
            $this->toDate,
        ])
            ->when($this->category, function ($query) {
                $query->whereCategory($this->category);
            })
            ->get()
            ->groupBy('category');

        $view = view('templates.pdf.expenses', [
            'expenses' => $expenses,
            'from' => $this->fromDate,
            'to' => $this->toDate,
        ])->render();

        $url = storage_path('app/public/documents/expenses.pdf');

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

        return redirect('/storage/documents/expenses.pdf');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.expense-report');
    }
}
