<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Storage;

class DatabaseBackupNotification extends Notification implements ShouldQueue
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
        $backups = Storage::disk('local')->files('backups');

//        dd($backups);

        return (new MailMessage)
            ->subject(config('app.name').' Database Backup')
            ->attach(storage_path().'/app/'.$backups[1]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
