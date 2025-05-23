<?php

namespace Jack\LogMonitor;

use Jack\LogMonitor\Services\LogInterface;

abstract class AbstractLogFactory
{
    public $data;
    public $type;

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
     * @return mixed
     */
    public function log($level, $message, array $context = [])
    {
        $log = $this->createLogger();
        return $log->log($level, $message, $context);
    }
}