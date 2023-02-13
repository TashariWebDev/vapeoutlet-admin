<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class CompressImagesCommand extends Command
{
    protected $signature = 'compress:images';

    protected $description = 'Compress all product images';

    public function handle()
    {
        $images = glob(storage_path('app/public/uploads/*'));

        foreach ($images as $image) {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain
                ->optimize($image);
        }
    }
}
