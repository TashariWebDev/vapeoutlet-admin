<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    protected $signature = 'test:email';

    protected $description = 'Command description';

    public function handle()
    {
        Mail::to('ridwan@tashari.co.za')
            ->send(new TestMail);
    }
}
