<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LolClient;

class LolServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('lolclient', function () {
            return new LolClient();
        });

        $this->app->alias(LolClient::class, 'lolclient');
    }
}