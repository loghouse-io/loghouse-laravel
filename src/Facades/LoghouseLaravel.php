<?php

namespace LoghouseIo\LoghouseLaravel\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class LoghouseLaravel
 * @package LoghouseIo\LoghouseLaravel\Facades
 *
 * @method static void log(string $message, array $metadata, ?string $bucketId)
 * @method static void send()
 */
class LoghouseLaravel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LoghouseLaravel';
    }
}
