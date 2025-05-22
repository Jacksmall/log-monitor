<?php

namespace Jack\LogMonitor;

use Exception;
use Illuminate\Support\Facades\Redis;

class LogMonitor
{
    protected $redisConnection;
    protected $redisKey;
    protected $maxLength;

    public function __construct($connection, $key, $maxLength)
    {
        $this->redisConnection = $connection;
        $this->redisKey = $key;
        $this->maxLength = $maxLength;
    }

    public function log($level, $message, array $context = [])
    {
        $logData = json_encode([
            'timestamp' => microtime(true),
            'level'     => $level,
            'message'   => $message,
            'context'   => $context,
            'host'      => gethostname(),
            'env'       => app()->environment()
        ]);

        Redis::connection($this->redisConnection)
            ->pipeline(function ($pipe) use ($logData) {
                $pipe->lpush($this->redisKey, $logData);
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