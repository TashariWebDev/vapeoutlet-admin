<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WholesaleDeclineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Customer $customer)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your wholesale account has been declined')
            ->greeting('Hi '.$this->customer->name)
            ->line('Unfortunately your application for a wholesale account has been declined at this point.')
            ->line('Please feel free to contact us if you would like to discuss the reasons for this.')
            ->action('Visit Website', url(config('app.frontend_url')))
            ->line('Thank you for your support and loyalty!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
