<?php

namespace LoghouseIo\LoghouseLaravel;

use DateTime;
use LoghouseIo\LoghouseLaravel\Exception\LoghouseLaravelEntryValidateException;

class LoghouseLaravel
{
    const URL = 'https://api.loghouse.io/log';

    /**
     * @var ?string
     */
    private $accessToken;

    /**
     * @var ?string
     */
    private $defaultBucketId;

    /**
     * @var array
     */
    private $entries = [];

    /**
     * LoghouseLaravel constructor.
     */
    public function __construct(string $accessToken = null, string $defaultBucketId = null)
    {
        $this->accessToken = $accessToken;
        $this->defaultBucketId = $defaultBucketId;
    }

    /**
     * @param string|null $message
     * @param array|null $metadata
     * @param string|null $bucketId
     */
    public function log(
        string $message = null,
        array $metadata = [],
        string $bucketId = null
    ) {
        if (empty($this->accessToken)) {
            return;
        }

        $bucketId = $bucketId ?? $this->defaultBucketId;

        try {
            $this->entryValidate($bucketId, $message, $metadata);
        } catch (LoghouseLaravelEntryValidateException $e) {
            return;
        }

        $this->addEntry($bucketId, $message, $metadata);

        if (app()->runningInConsole()) {
            $this->send();
        }
    }

    /**
     * @param string|null $bucketId
     * @param string|null $message
     * @param array|null $metadata
     * @throws LoghouseLaravelEntryValidateException
     */
    private function entryValidate(
        string $bucketId = null,
        string $message = null,
        array $metadata = []
    ) {
        if (empty($bucketId)) {
            throw new LoghouseLaravelEntryValidateException('Empty bucket_id');
        }

        if (empty($message)) {
            throw new LoghouseLaravelEntryValidateException('Empty message');
        }

        if (!is_array($metadata)) {
            throw new LoghouseLaravelEntryValidateException('Metadata is not array');
        }
    }

    /**
     * @param string $bucketId
     * @param string $message
     * @param array $metadata
     */
    private function addEntry(
        string $bucketId,
        string $message,
        array $metadata = []
    ) {

        $entry = [
            'bucket_id' => $bucketId,
            'message' => $message,
            'timestamp' => (new DateTime())->format('c')
        ];

        if (!empty($metadata)) {
            $entry['metadata'] = $metadata;
        }

        $this->entries[] = $entry;
    }

    private function resetEntries()
    {
        $this->entries = [];
    }

    public function send()
    {
        if (empty($this->accessToken) || count($this->entries) == 0) {
            return;
        }

        $ch = curl_init(self::URL);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'access_token' => $this->accessToken,
            'entries' => $this->entries
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        $this->resetEntries();
    }
}
