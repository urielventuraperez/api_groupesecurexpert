<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        LumenPassport::allowMultipleTokens();
    }

    public function boot() { 
        \Dusterio\LumenPassport\LumenPassport::routes($this->app->router, ['prefix' => 'api'] ); 
    }
}
