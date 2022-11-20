<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockAlertMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        return $this->view('emails.stock-alert', [
            'link' => config('app.frontend_url').'/detail/'.$this->product->id,
            'name' => $this->product->brand.' '.$this->product->name,
        ]);
    }
}
