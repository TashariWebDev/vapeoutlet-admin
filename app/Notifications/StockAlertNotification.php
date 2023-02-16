<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Product $product)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $name =
            ucwords($this->product->brand).
            ' '.
            ucwords($this->product->name);

        return (new MailMessage())
            ->subject($name.' back in stock!')
            ->line('Just letting you know that '.$name.' is back in stock')
            ->line('Hurry before its all gone...')
            ->action(
                'Shop Now',
                url(
                    config('app.frontend_url').'/detail/'.$this->product->id
                )
            )
            ->line('Thank you for your support!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
