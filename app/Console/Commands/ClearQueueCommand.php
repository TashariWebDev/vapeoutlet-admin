<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ClearQueueCommand extends Command
{
    protected $signature = 'clear:queue';

    protected $description = 'Clear jobs table';

    public function handle(): void
    {
        DB::table('jobs')->delete();
    }
}
