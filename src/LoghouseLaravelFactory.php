<?php

namespace LoghouseIo\LoghouseLaravel;


use LoghouseIo\LoghouseLaravel\Handlers\LoghouseLaravelHandler;
use Monolog\Logger;

/**
 * Class LoghouseLaravelFactory
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravelFactory
{
    /**
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $bucketId = $config['bucket_id'] ?? null;

        $logger = new Logger('LoghouseLaravel');
        $handler = new LoghouseLaravelHandler($bucketId);
        $logger->pushHandler($handler);
        return $logger;
    }
}