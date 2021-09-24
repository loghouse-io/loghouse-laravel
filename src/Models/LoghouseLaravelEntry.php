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
    public function setUserId(int $userId = null): void;

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void;

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId): void;

    /**
     * @return bool
     */
    public function isUncaughtException(): bool;

    /**
     * @return array
     */
    public function serialize(): array;
}
