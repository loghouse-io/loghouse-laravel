<?php

namespace LoghouseIo\LoghouseLaravel\Models;

/**
 * Class LoghouseLaravelConfigImpl
 * @package LoghouseIo\LoghouseLaravel\Models
 */
class LoghouseLaravelConfigImpl implements LoghouseLaravelConfig
{
    /**
     * @var bool
     */
    private $isConsole;

    /**
     * @var string|null
     */
    private $accessToken;

    /**
     * @var string|null
     */
    private $defaultBucketId;

    /**
     * LoghouseLaravelConfigImpl constructor.
     * @param string|null $accessToken
     * @param string|null $defaultBucketId
     * @param bool $isConsole
     */
    public function __construct(
        bool $isConsole,
        string $accessToken = null,
        string $defaultBucketId = null
    ) {
        $this->isConsole = $isConsole;
        $this->accessToken = $accessToken;
        $this->defaultBucketId = $defaultBucketId;

    }

    /**
     * @return bool
     */
    public function isConsole(): bool
    {
        return $this->isConsole;
    }

    /**
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function hasAccessToken(): bool
    {
        return (bool) $this->accessToken;
    }

    /**
     * @return string|null
     */
    public function getDefaultBucketId()
    {
        return $this->defaultBucketId;
    }
}
