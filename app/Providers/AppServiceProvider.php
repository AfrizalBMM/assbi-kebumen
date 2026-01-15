<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Imagick;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (extension_loaded('imagick')) {
            Imagick::setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 256);
            Imagick::setResourceLimit(Imagick::RESOURCETYPE_MAP, 256);
            Imagick::setResourceLimit(Imagick::RESOURCETYPE_DISK, 1024);
        }
    }
}
