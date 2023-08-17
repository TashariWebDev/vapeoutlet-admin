<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestTailwindcssMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build(): self
    {
        $customer = Customer::first();

        return $this->view('emails.admin.customers.registered', [
            'customer' => $customer,
        ])
            ->subject('Customer registered');
    }
}
