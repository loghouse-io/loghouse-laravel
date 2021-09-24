<?php

namespace LoghouseIo\LoghouseLaravel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LoghouseIo\LoghouseLaravel\Factories\LoghouseLaravelEntryFactory;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelConfig;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntriesStorage;
use LoghouseIo\LoghouseLaravel\Utils\LoghouseLaravelHttpClient;

/**
 * Class LoghouseLaravel
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravel
{
    /**
     * @var LoghouseLaravelConfig
     */
    private $config;

    /**
     * @var LoghouseLaravelEntriesStorage
     */
    private $entriesStorage;

    /**
     * LoghouseLaravel constructor.
     * @param LoghouseLaravelConfig $config
     * @param LoghouseLaravelEntriesStorage $entriesStorage
     */
    public function __construct(
        LoghouseLaravelConfig $config,
        LoghouseLaravelEntriesStorage $entriesStorage
    ) {
        $this->config = $config;
        $this->entriesStorage = $entriesStorage;
    }

    /**
     * @param string $message
     * @param array $metadata
     * @param string|null $bucketId
     */
    public function log(
        string $message,
        array $metadata = [],
        string $bucketId = null
    ) {
        if (!$this->config->hasAccessToken()) {
            return;
        }

        $bucketId = $bucketId ?? $this->config->getDefaultBucketId();

        if (!$this->validate($bucketId, $message)) {
            return;
        }

        $entry = LoghouseLaravelEntryFactory::create($bucketId, $message, $metadata);

        $this->entriesStorage->addEntry($entry);

        if ($this->config->isConsole()) {
            $this->send();
        }

        if ($entry->isUncaughtException()) {
            $this->send(500);
        }
    }

    /**
     * @param string|null $bucketId
     * @param string|null $message
     * @return bool
     */
    private function validate(
        string $bucketId = null,
        string $message = null
    ): bool {
        return !empty($bucketId) && !empty($message);
    }

    /**
     * @param int $httpStatusCode
     */
    public function send(int $httpStatusCode = 200)
    {
        if (!$this->config->hasAccessToken() || !$this->entriesStorage->hasEntries()) {
            return;
        }

        LoghouseLaravelHttpClient::send(
            $this->config->getAccessToken(),
            $this->entriesStorage->serialize($httpStatusCode)
        );

        $this->entriesStorage->reset();
    }
}
