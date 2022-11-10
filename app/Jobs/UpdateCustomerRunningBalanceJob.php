<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCustomerRunningBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Customer $customer;

    public function __construct($customerId)
    {
        $this->customer = Customer::findOrFail($customerId);
    }

    public function handle()
    {
        $this->customer->load('transactions');
        $balance = 0;
        foreach ($this->customer->transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }
    }
}
