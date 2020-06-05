<?php

namespace Task3\Helpers;

use Predis\Client;

class RedisConnection
{
    const REDIS_KEY = 'products-';
    const REDIS_TTL = 3600;

    protected static $instance;

    protected function __construct() {}

    public static function getConnection() {

        if(empty(self::$instance)) {

            $redisConf = [
                'scheme' => 'tcp',
                'host'   => 'redis',
                'port'   => 6379,
            ];

            self::$instance = new Client($redisConf);
        }

        return self::$instance;
    }
}