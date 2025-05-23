<?php
return [
    'default' => env('LOG_MONITOR_CHANNEL', 'redis'),
    'channels' => [
        'redis' => [
            'connection'  => 'default',
            'key'        => 'logmonitor:logs',
            'max_length' => 100000
        ]
    ]
];
