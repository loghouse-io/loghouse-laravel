<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Class EntryImpl
 * @package LoghouseIo\LoghouseLaravel\Models
 */
class LoghouseLaravelEntryImpl implements LoghouseLaravelEntry
{
    /**
     * @var string
     */
    private $bucketId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var array
     */
    private $metadata;

    /**
     * LoghouseLaravelEntryImpl constructor.
     * @param string $bucketId
     * @param string $message
     * @param string $timestamp
     * @param array $metadata
     */
    public function __construct(
        string $bucketId,
        string $message,
        string $timestamp,
        array $metadata = []
    ) {
        $this->bucketId = $bucketId;
        $this->message = $message;
        $this->timestamp = $timestamp;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getBucketId(): string
    {
        return $this->bucketId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(int $userId = null): void
    {
        $this->metadata['user_id'] = $userId;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->metadata['ip'] = $ip;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId): void
    {
        $this->metadata['request_id'] = $requestId;
    }

    /**
     * @return bool
     */
    public function isUncaughtException(): bool
    {
        return isset($this->metadata['error']['caught']) && $this->metadata['error']['caught'] === false;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'bucket_id' => $this->bucketId,
            'message' => $this->message,
            'timestamp' => $this->timestamp,
            'metadata' => $this->metadata
        ];
    }
}
