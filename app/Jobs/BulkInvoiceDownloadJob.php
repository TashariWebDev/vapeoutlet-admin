<?php

namespace App\Jobs;

use App\Notifications\BulkInvoiceDownloadNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use ZipArchive;

class BulkInvoiceDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;

    public function __construct(public $batch)
    {

    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function handle(): void
    {
        $folderPath = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documentBatch');

        if (! file_exists($folderPath)) {
            mkdir($folderPath, 0777);
        }

        $files = glob($folderPath.'/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        foreach ($this->batch as $order) {
            $view = view('templates.pdf.invoice', [
                'order' => $order,
            ])->render();

            $url = storage_path(
                'app/public/'.
                config('app.storage_folder').
                "/documentBatch/$order->number.pdf"
            );

            if (file_exists($url)) {
                unlink($url);
            }

            Browsershot::html($view)
                ->showBackground()
                ->emulateMedia('print')
                ->format('a4')
                ->paperSize(297, 210)
                ->setScreenshotType('pdf', 60)
                ->save($url);
        }

        $zip_file = public_path('batch.zip');
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/public/vapeoutlet/documentBatch');

        $batch = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($batch as $file) {
            if (! $file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = 'invoices/'.substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        Notification::route('mail', config('mail.from.address'))
            ->notify(new BulkInvoiceDownloadNotification);
    }
}
