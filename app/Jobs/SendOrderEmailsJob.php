<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\OrderConfirmedNotification;
use App\Notifications\OrderReceivedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendOrderEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function handle(): void
    {
        Notification::route('mail', $this->order->customer->email)->notify(
            new OrderConfirmedNotification()
        );

        Notification::route('mail', config('mail.from.address'))->notify(
            new OrderReceivedNotification($this->order->customer)
        );
    }
}
