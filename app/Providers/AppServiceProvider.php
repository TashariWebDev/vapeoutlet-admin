<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::if('hasPermissionTo', function ($permission) {
            return auth()
                ->user()
                ->hasPermissionTo($permission);
        });

        DB::listen(function ($query) {
            view()->share('queryTime', $query->time);
        });

//        $folders = ['documents', 'images', 'uploads'];
//        foreach ($folders as $folder) {
//            if (! file_exists(storage_path("app/public/$folder"))) {
//                mkdir(storage_path("app/public/$folder"), 0777, true);
//            }
//
//            chmod(storage_path("app/public/$folder"), 0777);
//        }
    }
}
