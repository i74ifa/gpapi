<?php

namespace I74ifa\Gpapi;

use Illuminate\Support\ServiceProvider;

class GpapiServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'gpapi'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('gpapi.php')
        ]);
    }
}
