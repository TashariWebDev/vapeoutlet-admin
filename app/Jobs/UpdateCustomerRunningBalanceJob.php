<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCustomerRunningBalanceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Customer $customer;

    public function __construct($customerId)
    {
        $this->customer = Customer::findOrFail($customerId);
    }

    public function handle()
    {
        $transactions = Transaction::where(
            'customer_id',
            $this->customer->id
        )->get();
        $balance = 0;
        foreach ($transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }
    }
}
