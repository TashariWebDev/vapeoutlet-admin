<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $helperFiles = glob(app_path('Helpers').'/*.php');

        foreach ($helperFiles as $helperFile) {
            require_once $helperFile;
        }
    }

    public function boot()
    {
    }
}
