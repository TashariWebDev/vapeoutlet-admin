<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOldDocumentsCommand extends Command
{
    protected $signature = 'delete:old-documents';

    protected $description = 'Delete old documents';

    public function handle()
    {
        $folder = glob(storage_path('app/public/documents/*'));

        foreach ($folder as $document) {
            unlink($document);
        }
    }
}
