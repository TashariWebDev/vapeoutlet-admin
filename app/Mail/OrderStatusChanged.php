<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

    public string $status;

    public function __construct(Order $order, $status)
    {
        $order->load('customer');

        $this->order = $order;
        $this->status = $status;
    }

    public function build()
    {
        return $this->view('emails.order-status-changed');
    }
}
