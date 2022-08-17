<?php

namespace App\Http\Livewire\Expenses;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showExpenseCategoryCreateForm = false;
    public $showAddExpenseForm = false;

    public $searchTerm = "";

    public $categoryName;

    public $category;
    public $vat_number;
    public $invoice_no;
    public $reference;
    public $amount;
    public $date;
    public $taxable = true;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            "category" => ["required"],
            "reference" => ["required"],
            "vat_number" => ["nullable"],
            "invoice_no" => ["required"],
            "amount" => ["required"],
            "date" => ["required"],
            "taxable" => ["required"],
        ];
    }

    public function addCategory()
    {
        $this->validate([
            "categoryName" => ["required", "unique:expense_categories,name"],
        ]);

        ExpenseCategory::create([
            "name" => $this->categoryName,
        ]);

        $this->reset(["categoryName"]);

        $this->notify("category created");
    }

    public function saveExpense()
    {
        $validatedData = $this->validate();

        $additionalFields = [
            "created_by" => auth()->user()->name,
            "processed_date" => today(),
        ];

        $expense = array_merge($validatedData, $additionalFields);

        Expense::create($expense);

        $this->reset([
            "category",
            "reference",
            "vat_number",
            "invoice_no",
            "amount",
            "date",
            "taxable",
        ]);

        $this->showAddExpenseForm = false;

        $this->notify("expense created");
    }

    public function remove(Expense $expense)
    {
        $expense->delete();
        $this->notify("expense deleted");
    }

    public function render()
    {
        return view("livewire.expenses.index", [
            "expenseCategories" => ExpenseCategory::query()
                ->orderBy("name")
                ->get(),
            "expenses" => Expense::query()
                ->orderBy("date")
                ->when($this->searchTerm, function ($query) {
                    $query
                        ->where("category", "like", $this->searchTerm . "%")
                        ->orWhere("date", "like", $this->searchTerm)
                        ->orWhere("invoice_no", "like", $this->searchTerm);
                })
                ->paginate(5),
        ]);
    }
}
