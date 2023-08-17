<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Customer $customer)
    {
    }

    public function build(): OrderConfirmedMail
    {
        return $this->view('emails.orders.confirmed')
            ->subject('Order Confirmed');
    }
}
