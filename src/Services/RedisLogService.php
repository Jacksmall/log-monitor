<?php

namespace Jack\LogMonitor\Services;

use Illuminate\Support\Facades\Redis;

class RedisLogService implements LogInterface
{
    protected $redisConnection;
    protected $redisKey;
    protected $maxLength;
    protected $data = [];

    public function __construct($type, $data)
    {
        $config = config('logmonitor.'.$type);
        $this->redisConnection = $config['connection'];
        $this->redisKey = $config['key'];
        $this->maxLength = $config['max_length'];
        $this->data = $data;
    }

    public function log($level, $message, array $context = [])
    {
        $this->data['level'] = $level;
        $this->data['message'] = $message;
        $this->data['context'] = $context;

        Redis::connection($this->redisConnection)->pipeline(function ($pipe) {
            $pipe->lpush($this->redisKey, json_encode($this->data, JSON_UNESCAPED_UNICODE));
            $pipe->ltrim($this->redisKey, 0, $this->maxLength - 1);
        });
    }
}