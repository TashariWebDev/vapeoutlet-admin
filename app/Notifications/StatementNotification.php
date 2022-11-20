<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatementNotification extends Notification implements ShouldQueue
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
        $statement = $this->customer->statement;

        return (new MailMessage())
            ->greeting('Hi '.ucwords($this->customer->name))
            ->line('Please find attached statement')
            ->line('Thank you for your loyal support. ')
            ->attach(storage_path("app/public/documents/$statement.pdf"));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
