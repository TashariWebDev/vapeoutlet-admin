<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Image;
use App\Models\MarketingBanner;
use App\Models\Product;
use App\Models\SystemSetting;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Str;

class RenameAllExistingImagesCommand extends Command
{
    protected $signature = 'rename:all-existing-images';

    protected $description = 'Rename all existing images';

    public function handle()
    {
        $system = SystemSetting::first();

        if (! Str::startsWith($system->logo, config('app.storage_folder'))) {
            $url = $system->logo;

            if (Str::startsWith($url, 'storage/vapecrew/')) {
                $url = str_replace('storage/vapecrew/', '', $url);
            }

            if (Str::startsWith($url, 'vapecrew/')) {
                $url = str_replace('vapecrew/', '', $url);
            }

            if (Str::startsWith($url, '//')) {
                $url = str_replace('//', '', $url);
            }

            if (Str::startsWith($url, 'storage/')) {
                $url = str_replace('storage/', '', $url);
            }

            $system->update([
                'logo' => config('app.storage_folder').'/'.$url,
            ]);
        }

        $banners = MarketingBanner::all();

        $banners->each(function ($banner) {
            if (
                ! Str::startsWith($banner->image, config('app.storage_folder'))
            ) {
                $url = $banner->image;

                if (Str::startsWith($url, 'storage/vapecrew/')) {
                    $url = str_replace('storage/vapecrew/', '', $url);
                }

                if (Str::startsWith($url, 'vapecrew/')) {
                    $url = str_replace('vapecrew/', '', $url);
                }

                if (Str::startsWith($url, '//')) {
                    $url = str_replace('//', '', $url);
                }

                if (Str::startsWith($url, 'storage/')) {
                    $url = str_replace('storage/', '', $url);
                }

                $banner->update([
                    'image' => config('app.storage_folder').'/'.$url,
                ]);
            }
        });

        $brands = Brand::all();

        $brands->each(function ($brand) {
            if (! Str::startsWith($brand->image, config('app.storage_folder'))) {
                $url = $brand->image;

                if (Str::startsWith($url, 'storage/vapecrew/')) {
                    $url = str_replace('storage/vapecrew/', '', $url);
                }

                if (Str::startsWith($url, 'vapecrew/')) {
                    $url = str_replace('vapecrew/', '', $url);
                }

                if (Str::startsWith($url, '//')) {
                    $url = str_replace('//', '', $url);
                }

                if (Str::startsWith($url, 'storage/')) {
                    $url = str_replace('storage/', '', $url);
                }

                $brand->update([
                    'image' => config('app.storage_folder').'/'.$url,
                ]);
            }
        });

        $images = Image::all();

        $images->each(function ($image) {
            if (! Str::startsWith($image->url, config('app.storage_folder'))) {
                $url = $image->url;

                if (Str::startsWith($url, 'storage/vapecrew/')) {
                    $url = str_replace('storage/vapecrew/', '', $url);
                }

                if (Str::startsWith($url, 'vapecrew/')) {
                    $url = str_replace('vapecrew/', '', $url);
                }

                if (Str::startsWith($url, '//')) {
                    $url = str_replace('//', '', $url);
                }

                if (Str::startsWith($url, 'storage/')) {
                    $url = str_replace('storage/', '', $url);
                }

                $image->update([
                    'url' => config('app.storage_folder').'/'.$url,
                ]);
            }
        });

        $products = Product::all();

        $products->each(function ($product) {
            if (
                ! Str::startsWith($product->image, config('app.storage_folder'))
            ) {
                $url = $product->image;

                if (Str::startsWith($url, 'storage/vapecrew/')) {
                    $url = str_replace('storage/vapecrew/', '', $url);
                }

                if (Str::startsWith($url, 'vapecrew/')) {
                    $url = str_replace('vapecrew/', '', $url);
                }

                if (Str::startsWith($url, '//')) {
                    $url = str_replace('//', '', $url);
                }

                if (Str::startsWith($url, 'storage/')) {
                    $url = str_replace('storage/', '', $url);
                }

                $product->update([
                    'image' => config('app.storage_folder').'/'.$url,
                ]);
            }
        });

        // Move folders

        if (! Storage::disk('public')->exists(config('app.storage_folder'))) {
            Storage::disk('public')->makeDirectory(
                config('app.storage_folder')
            );
        }

        if (Storage::disk('public')->exists('documents')) {
            Storage::disk('public')->move(
                'documents',
                config('app.storage_folder').'/documents'
            );
        }

        if (Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->move(
                'uploads',
                config('app.storage_folder').'/uploads'
            );
        }

        if (Storage::disk('public')->exists('images')) {
            Storage::disk('public')->move(
                'images',
                config('app.storage_folder').'/images'
            );
        }

        if (file_exists(public_path('storage'))) {
            unlink(public_path('storage'));
        }

        Artisan::call('storage:link');
    }
}
