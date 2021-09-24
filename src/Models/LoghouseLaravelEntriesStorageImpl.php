<?php

namespace LoghouseIo\LoghouseLaravel\Models;


use Illuminate\Http\Request;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntriesStorageRequestConfig;

/**
 * Class LoghouseLaravelEntriesStorageImpl
 * @package LoghouseIo\LoghouseLaravel\Models
 */
class LoghouseLaravelEntriesStorageImpl implements LoghouseLaravelEntriesStorage
{
    /**
     * @var bool
     */
    private $isConsole;

    /**
     * @var LoghouseLaravelRequestEntry
     */
    private $requestEntry;

    /**
     * @var array
     */
    private $entries = [];

    /**
     * LoghouseLaravelEntriesStorage constructor.
     */
    public function __construct(
        bool $isConsole,
        LoghouseLaravelRequestEntry $requestEntry
    ) {
        $this->isConsole = $isConsole;
        $this->requestEntry = $requestEntry;
    }

    /**
     * @param LoghouseLaravelEntry $entry
     */
    public function addEntry(LoghouseLaravelEntry $entry)
    {
        if (!$this->isConsole) {
            $entry->setUserId($this->requestEntry->getUserId());
            $entry->setIp($this->requestEntry->getIp());
            $entry->setRequestId($this->requestEntry->getRequestId());
        }

        $this->entries[$entry->getBucketId()][] = $entry;
    }

    /**
     * @return bool
     */
    public function hasEntries(): bool
    {
        foreach ($this->entries as $bucketEntries) {
            if (count($bucketEntries) > 0) {
                return true;
            }
        }

        return false;
    }

    public function reset()
    {
        $this->entries = [];
    }

    public function serialize(int $httpStatusCode = 200): array
    {
        if (!$this->hasEntries()) {
            return [];
        }

        $requestEntrySerialize = null;
        if (!$this->isConsole) {
            $this->requestEntry->setStatusCode($httpStatusCode);
            $requestEntrySerialize = $this->requestEntry->serialize();
        }

        $serializeEntries = [];

        foreach ($this->entries as $bucketId => $bucketEntries) {
            if (!$this->isConsole) {
                $requestEntrySerialize['bucket_id'] = $bucketId;
                $serializeEntries[] = $requestEntrySerialize;
            }

            foreach ($bucketEntries as $entry) {
                $serializeEntries[] = $entry->serialize();
            }
        }

        return $serializeEntries;
    }
}
