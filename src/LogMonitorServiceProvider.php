<?php

namespace Jack\LogMonitor;

use Illuminate\Support\ServiceProvider;
use Jack\LogMonitor\Factory\RedisLogFactory;

class LogMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logmonitor.php', 'logmonitor');
        $this->app->bind(RedisLogFactory::class, function ($app) {
            return LogFactoryRouter::createFactory(config('logmonitor.default'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logmonitor.php' => config_path('logmonitor.php'),
        ], 'logmonitor-config');
    }
}