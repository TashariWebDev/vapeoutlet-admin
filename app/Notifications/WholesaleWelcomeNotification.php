<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WholesaleWelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public float $maxPurchaseValueForFreeDelivery;

    public function __construct(public Customer $customer)
    {
        $this->maxPurchaseValueForFreeDelivery = to_rands(Delivery::query()->where('customer_type', '=',
            'wholesale')->max('waiver_value'));
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your wholesale account has been approved')
            ->greeting('Hi '.$this->customer->name)
            ->line('We are happy to inform you that your account has been upgraded to a wholesale account.')
            ->lines([
                'Please note the following:',
                "- All orders above the invoice value of R $this->maxPurchaseValueForFreeDelivery qualifies for a Free National Delivery.",
                '- All prices on the website at VAT inclusive',
            ])
            ->action('Start shopping', url(config('app.frontend_url')))
            ->line('Thank you for your support and loyalty!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
