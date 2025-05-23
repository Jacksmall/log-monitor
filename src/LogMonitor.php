<?php

namespace Jack\LogMonitor;

use Exception;
use Illuminate\Support\Facades\Redis;

class LogMonitor
{
    protected $redisConnection;
    protected $redisKey;
    protected $maxLength;
    protected $data = [];

    public function __construct($connection, $key, $maxLength)
    {
        $this->redisConnection = $connection;
        $this->redisKey = $key;
        $this->maxLength = $maxLength;
        $this->initData();
    }

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

    public function log($level, $message, array $context = [])
    {
        $this->set('level', $level);
        $this->set('message', $message);
        $this->set('context', $context);

        Redis::connection($this->redisConnection)->pipeline(function ($pipe) {
            $pipe->lpush($this->redisKey, $this->data);
            $pipe->ltrim($this->redisKey, 0, $this->maxLength - 1);
        });
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