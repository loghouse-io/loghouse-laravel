<?php

namespace LoghouseIo\LoghouseLaravel\Models;


/**
 * Interface LoghouseLaravelEntriesStorage
 * @package LoghouseIo\LoghouseLaravel\Handlers
 */
interface LoghouseLaravelEntriesStorage
{
    /**
     * @param LoghouseLaravelEntry $entry
     */
    public function addEntry(LoghouseLaravelEntry $entry): void;

    /**
     * @return bool
     */
    public function hasEntries(): bool;

    /**
     * @param int $httpStatusCode
     * @return array
     */
    public function serialize(int $httpStatusCode = 200): array;
    
    public function reset(): void;
}
