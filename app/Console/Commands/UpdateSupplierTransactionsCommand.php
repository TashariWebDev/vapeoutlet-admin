<?php

namespace App\Console\Commands;

use App\Models\Supplier;
use Illuminate\Console\Command;

class UpdateSupplierTransactionsCommand extends Command
{
    protected $signature = 'update:supplier-transactions {supplier?}';

    protected $description = 'Update all user transactions to reflect running balance';

    public function handle()
    {
        $supplier = Supplier::find($this->argument("supplier"));

        if ($supplier) {
            $supplier->load("transactions");
            $balance = 0;
            foreach ($supplier->transactions as $transaction) {
                $balance += $transaction->amount;
                $transaction->running_balance = $balance;
                $transaction->save();
            }
        } else {
            $suppliers = Supplier::all();

            foreach ($suppliers as $supplier) {
                $balance = 0;
                foreach ($supplier->transactions as $transaction) {
                    $balance += $transaction->amount;
                    $transaction->running_balance = $balance;
                    $transaction->save();
                }
            }
        }
    }
}
