<?php

namespace Jack\LogMonitor;

use Jack\LogMonitor\Services\LogInterface;

abstract class AbstractLogFactory
{
    /**
     * @return LogInterface
     */
    abstract public function createLogger(): LogInterface;

    /**
     * 记录日志
     *
     * @param $level
     * @param $message
     * @param array $context
     * @param array $data
     * @return mixed
     */
    public function log($level, $message, array $context = [], array $data = [])
    {
        $log = $this->createLogger();
        return $log->log($level, $message, $context, $data);
    }
}