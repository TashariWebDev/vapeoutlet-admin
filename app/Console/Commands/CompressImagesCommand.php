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
        $folder = glob(storage_path('app/public/uploads/*'));

        foreach ($folder as $image) {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($image);
            info($image);
        }
    }
}
