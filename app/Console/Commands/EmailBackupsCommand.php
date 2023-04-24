<?php

namespace App\Console\Commands;

use App\Notifications\DatabaseBackupNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class EmailBackupsCommand extends Command
{
    protected $signature = 'email:backups';

    protected $description = 'Email Database Backups';

    public function handle(): void
    {
        Notification::route('mail', config('app.super_admin_email'))
            ->notify(new DatabaseBackupNotification);
    }
}
