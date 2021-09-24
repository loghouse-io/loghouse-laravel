<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Interface LoghouseLaravelConfig
 * @package LoghouseIo\LoghouseLaravel\Models
 */
interface LoghouseLaravelConfig
{
    /**
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * @return bool
     */
    public function hasAccessToken(): bool;

    /**
     * @return string|null
     */
    public function getDefaultBucketId(): ?string;

    /**
     * @return bool
     */
    public function isConsole(): bool;
}