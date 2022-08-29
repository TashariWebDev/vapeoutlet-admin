<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOldPriceListCommand extends Command
{
    protected $signature = "delete:old-price-list";

    protected $description = "Delete old price list";

    public function handle()
    {
        $url = storage_path("app/public/documents/price-list-wholesale.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        $url = storage_path("app/public/documents/price-list-retail.pdf");

        if (file_exists($url)) {
            unlink($url);
        }
    }
}
