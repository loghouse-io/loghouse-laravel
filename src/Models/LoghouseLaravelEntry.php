<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Interface LoghouseLaravelEntry
 * @package LoghouseIo\LoghouseLaravel\Models
 */
interface LoghouseLaravelEntry
{
    /**
     * @return string
     */
    public function getBucketId(): string;

    /**
     * @param int|null $userId
     */
    public function setUserId(int $userId = null);

    /**
     * @param string $ip
     */
    public function setIp(string $ip);

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId);

    /**
     * @return bool
     */
    public function isUncaughtException(): bool;

    /**
     * @return array
     */
    public function serialize(): array;
}
