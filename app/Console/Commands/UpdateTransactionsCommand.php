<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;

class UpdateTransactionsCommand extends Command
{
    protected $signature = 'update:transactions {customer?}';

    protected $description = 'Update all user transactions to reflect running balance';

    public function handle()
    {
        $customer = Customer::find($this->argument("customer"));

        if ($customer) {
            $customer->load("transactions");
            $balance = 0;
            foreach ($customer->transactions as $transaction) {
                $balance += $transaction->amount;
                $transaction->running_balance = $balance;
                $transaction->save();
            }
        } else {
            $customers = Customer::all();

            foreach ($customers as $customer) {
                $balance = 0;
                foreach ($customer->transactions as $transaction) {
                    $balance += $transaction->amount;
                    $transaction->running_balance = $balance;
                    $transaction->save();
                }
            }
        }
    }
}
