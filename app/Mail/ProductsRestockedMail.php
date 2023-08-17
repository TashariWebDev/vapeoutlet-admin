<?php

namespace App\Mail;

use App\Models\Brand;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductsRestockedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Brand $brand, public Customer $customer)
    {
    }

    public function build(): self
    {
        return $this->view('emails.products-restocked')->subject('Restocked');
    }
}
