<?php

namespace Jack\LogMonitor\Factory;

use Jack\LogMonitor\AbstractLogFactory;
use Jack\LogMonitor\Services\LogInterface;
use Jack\LogMonitor\Services\RedisLogService;

class RedisLogFactory extends AbstractLogFactory
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function createLogger(): LogInterface
    {
        return new RedisLogService('redis', $this->data);
    }
}