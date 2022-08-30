<?php

namespace App\Jobs;

use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSupplierRunningBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Supplier $supplier;

    public function __construct($supplierId)
    {
        $this->supplier = Supplier::find($supplierId);
    }

    public function handle()
    {
        $this->supplier->load("transactions");
        $balance = 0;
        foreach ($this->supplier->transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }
    }
}
