<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Customer;
use Illuminate\Console\Command;

class UpdateTransactionsCommand extends Command
{
    protected $signature = 'update:transactions {customer?}';

    protected $description = 'Update all user transactions to reflect running balance';

    public function handle(): void
    {
        $customer = Customer::find($this->argument('customer'));

        if ($customer) {
            UpdateCustomerRunningBalanceJob::dispatch($customer->id);
        } else {
            $customers = Customer::all();

            foreach ($customers as $customer) {
                UpdateCustomerRunningBalanceJob::dispatch($customer->id);
            }
        }

        $this->info('complete');
    }
}
