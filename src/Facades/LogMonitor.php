<?php

namespace Jack\LogMonitor\Facades;

use Illuminate\Support\Facades\Facade;

class LogMonitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'logmonitor';
    }
}