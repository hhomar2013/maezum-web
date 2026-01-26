<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
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
    public function boot(): void
    {
          Livewire::setUpdateRoute(function ($handle) {
         return Route::post('/custom/livewire/update', $handle)
            ->middleware(['web']); // مهم وجود middleware web
            });


        require_once app_path('Helpers/Helpers.php');

        $locale = LaravelLocalization::getCurrentLocale();
        $direction = in_array($locale, ['ar', 'fa', 'he', 'ur']) ? 'rtl' : 'ltr';
        Config::set('app.direction', $direction);




    }
}
