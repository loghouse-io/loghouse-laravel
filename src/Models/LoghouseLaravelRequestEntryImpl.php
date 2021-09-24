<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Class LoghouseLaravelRequestEntryImpl
 * @package LoghouseIo\LoghouseLaravel\Models
 */
class LoghouseLaravelRequestEntryImpl implements LoghouseLaravelRequestEntry
{
    /**
     * @var string
     */
    private $requestId;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var
     */
    private $httpStatusCode;

    /**
     * LoghouseLaravelRequestEntryImpl constructor.
     * @param string $requestId
     * @param string $timestamp
     * @param array $metadata
     */
    public function __construct(
        string $requestId,
        string $timestamp,
        array  $metadata
    ) {
        $this->requestId = $requestId;
        $this->timestamp = $timestamp;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->metadata['ip'];
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->metadata['user_id'];
    }

    /**
     * @param int $httpStatusCode
     */
    public function setStatusCode(int $httpStatusCode): void
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->metadata['response']['code'] = $httpStatusCode;
    }

    public function serialize(): array
    {
        return [
            'message' => sprintf("%s %s %s",
                $this->httpStatusCode,
                $this->metadata['request']['method'],
                $this->metadata['request']['path']
            ),
            'timestamp' => $this->timestamp,
            'metadata' => $this->metadata
        ];
    }
}
