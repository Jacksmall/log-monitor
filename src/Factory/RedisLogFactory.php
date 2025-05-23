<?php

namespace Jack\LogMonitor\Factory;

use Jack\LogMonitor\AbstractLogFactory;
use Jack\LogMonitor\Services\LogInterface;
use Jack\LogMonitor\Services\RedisLogService;

class RedisLogFactory extends AbstractLogFactory
{
    /**
     * @inheritDoc
     */
    public function createLogger(): LogInterface
    {
        return new RedisLogService('redis');
    }
}