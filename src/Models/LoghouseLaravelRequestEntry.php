<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Interface LoghouseLaravelRequestEntry
 * @package LoghouseIo\LoghouseLaravel\Models
 */
interface LoghouseLaravelRequestEntry
{
    /**
     * @return string
     */
    public function getRequestId(): string;

    /**
     * @return string
     */
    public function getIp(): string;

    /**
     * @return int|null
     */
    public function getUserId(): ?int;

    /**
     * @param int $httpStatusCode
     */
    public function setStatusCode(int $httpStatusCode): void;

    /**
     * @return array
     */
    public function serialize(): array;
}
