<?php

namespace Jack\LogMonitor;

use Illuminate\Support\ServiceProvider;

class LogMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logmonitor.php', 'logmonitor');
        $this->app->singleton('logmonitor', function ($app, $params) {
            return LogFactoryRouter::createFactory($params['type'], $params['data']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logmonitor.php' => config_path('logmonitor.php'),
        ], 'logmonitor-config');
    }
}