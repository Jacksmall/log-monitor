<?php

namespace Jack\LogMonitor\Facades;

use Illuminate\Support\Facades\Facade;
use Jack\LogMonitor\Factory\RedisLogFactory;

class LogMonitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RedisLogFactory::class;
    }
}