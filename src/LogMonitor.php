<?php

namespace Jack\LogMonitor;

use Exception;

class LogMonitor
{
    private $type = 'redis';

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

    public function setType($type)
    {
        $this->type = $type;
    }

    public function log($level, $message, $context = [])
    {
        /** @var AbstractLogFactory $factory */
        $factory = app(AbstractLogFactory::class, ['type' => $this->type, 'data' => $this->data]);
        $factory->log($level, $message, $context);
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