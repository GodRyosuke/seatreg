<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Seat;
use App\Observers\SeatObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $proxy_url    = config('trustedproxy.proxy_url');
        $proxy_schema = config('trustedproxy.proxy_schema');
        
        if (!empty($proxy_url)) {
            URL::forceRootUrl($proxy_url);
        }

        if (!empty($proxy_schema)) {
            URL::forceScheme($proxy_schema);
        }

        Seat::observe(SeatObserver::class); 
    }
}
