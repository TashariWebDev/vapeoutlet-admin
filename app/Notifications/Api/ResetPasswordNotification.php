<?php

namespace App\Notifications\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $url)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset Link')
//            ->salutation('Hi '.ucwords($this->user->name))
            ->line('Kindly click on the link below to reset your password')
            ->action('Reset Password', $this->url)
            ->line('Thank you!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
