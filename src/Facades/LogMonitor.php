<?php

namespace Jack\LogMonitor\Facades;

use Illuminate\Support\Facades\Facade;
use Jack\LogMonitor\AbstractLogFactory;

class LogMonitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AbstractLogFactory::class;
    }
}