<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Customer $customer;

    public function __construct($customerId)
    {
        $this->customer = Customer::find($customerId);
    }

    public function build()
    {
        return $this->view('emails.order-received');
    }
}
