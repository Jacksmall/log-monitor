<?php

namespace Jack\LogMonitor;

use Jack\LogMonitor\Factory\RedisLogFactory;

class LogFactoryRouter
{
    private static $cachedFactories = [];

    const MAPPING = [
        'redis' => RedisLogFactory::class
    ];

    /**
     * @param $type
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public static function createFactory($type, $data)
    {
        if (isset(self::$cachedFactories[$type])) {
            return self::$cachedFactories[$type];
        }

        if (!isset(self::MAPPING[$type])) {
            throw new \Exception("无效的第三方通道类型: {$type}");
        }

        $factoryName = self::MAPPING[$type];
        $factory = new $factoryName($data);

        return self::$cachedFactories[$type] = $factory;
    }
}