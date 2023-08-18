<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $enquiry;

    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Vape Crew Contact Form')
            ->line('From: '.$this->enquiry['name'])
            ->line('Phone: '.$this->enquiry['phone'])
            ->line('Email: '.$this->enquiry['email'])
            ->line('Message: '.$this->enquiry['body']);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
