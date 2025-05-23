<?php

namespace Jack\LogMonitor;

use Exception;
use Jack\LogMonitor\Services\LogInterface;

abstract class AbstractLogFactory
{
    private $data = [];

    public function __construct()
    {
        $this->initData();
    }

    /**
     * @return void
     */
    protected function initData()
    {
        $this->data = [
            'timestamp' => microtime(true),
            'host'      => gethostname(),
            'env'       => app()->environment()
        ];
    }

    public function set($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function get($name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }

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
        return $log->log($level, $message, $context, $this->data);
    }

    public function catchException(Exception $exception)
    {
        $this->log('ERROR', $exception->getMessage(), [
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}