<?php

namespace App\Providers;

use App\Services\Yobit;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class YobitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Yobit::class, function (Application $app) {
            $config = $app->make('config')->get('yobit');

            return new Yobit($config);

        });
    }
}
