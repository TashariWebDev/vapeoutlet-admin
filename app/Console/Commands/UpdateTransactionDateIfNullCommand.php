<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class UpdateTransactionDateIfNullCommand extends Command
{
    protected $signature = 'update:transaction-date-if-null';

    protected $description = 'Command description';

    public function handle(): void
    {
        $transactions = Transaction::whereNull('date')->get();

        $transactions->each(function ($transaction) {
            $transaction->update([
                'date' => $transaction->created_at,
            ]);
        });
    }
}
