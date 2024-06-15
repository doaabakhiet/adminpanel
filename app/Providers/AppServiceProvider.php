<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\System;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
        Schema::defaultStringLength(191);

         //Blade directive to format number into required format.
         Blade::directive('num_format', function ($expression) {
            $currency_precision =2;
            return "number_format($expression,  $currency_precision, '.', ',')";
        });

        //Blade directive to convert.
        Blade::directive('format_date', function ($date = null) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y')";
            } else {
                return null;
            }
        });
        if(Schema::hasTable('systems')){
            $settings = Setting::pluck('value', 'key');
            view()->share('settings',$settings);
        }
        Paginator::useBootstrap();
    }
}
