<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Order Confirmed')
            ->line(
                'Thank you for placing your order with '.config('app.name')
            )
            ->action('View your order', url('/'))
            ->line('Our team will be jumping on it right away.')
            ->line('Keep a look-out for updates in your email.')
            ->line('Thank you for your support!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
