<?php

namespace App\Console\Commands;

use App\Mail\OrderRecoveryMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ManuallySendCartRecoveryEmailCommand extends Command
{
    protected $signature = 'recover:cart {order?}';

    protected $description = 'Manually send cart recovery emails';

    public function handle(): void
    {
        $order = Order::whereNull('status')
            ->where('id', '=', $this->argument('order'))
            ->first();

        Mail::to($order->customer->email)->send(
            new OrderRecoveryMail($order)
        );
    }
}
