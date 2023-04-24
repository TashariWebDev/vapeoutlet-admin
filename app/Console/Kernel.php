<?php

namespace App\Console;

use App\Console\Commands\CompressImagesCommand;
use App\Console\Commands\DeleteOldDocumentsCommand;
use App\Console\Commands\DeleteOldPriceListCommand;
use App\Console\Commands\EmailBackupsCommand;
use App\Console\Commands\ShopSetupCommand;
use App\Console\Commands\TestEmailCommand;
use App\Console\Commands\UpdateSupplierTransactionsCommand;
use App\Console\Commands\UpdateTransactionDateIfNullCommand;
use App\Console\Commands\UpdateTransactionsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateTransactionsCommand::class,
        DeleteOldPriceListCommand::class,
        DeleteOldDocumentsCommand::class,
        UpdateSupplierTransactionsCommand::class,
        CompressImagesCommand::class,
        TestEmailCommand::class,
        ShopSetupCommand::class,
        UpdateTransactionDateIfNullCommand::class,
        EmailBackupsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('delete:old-price-list')->everyTenMinutes();
        $schedule->command('delete:old-documents')->days(2);
        $schedule->command('compress:images')->weeklyOn(6);
        $schedule->command('update:transactions')->hourly();
        $schedule->command('update:supplier-transactions')->hourly();
        $schedule->command('backup:clean')->daily('01:00');
        $schedule->command('backup:run')->daily('01:10');
        $schedule->command('email:backups')->daily('01:30');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
