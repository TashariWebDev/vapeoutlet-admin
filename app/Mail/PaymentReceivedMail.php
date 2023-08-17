<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public Transaction $transaction,
        public $createdBy,
    ) {
    }

    public function build(): self
    {
        return $this->view('emails.admin.orders.payment')
            ->subject('Online payment received');
    }
}
