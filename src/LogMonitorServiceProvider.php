<?php

namespace Jack\Logmonitor;

use Illuminate\Support\ServiceProvider;

class LogMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logmonitor.php', 'logmonitor');

        $this->app->singleton('logmonitor', function ($app) {
            return new LogMonitor(
                config('logmonitor.redis.connection'),
                config('logmonitor.redis.key'),
                config('logmonitor.redis.max_length')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logmonitor.php' => config_path('logmonitor.php'),
        ], 'logmonitor-config');
    }
}