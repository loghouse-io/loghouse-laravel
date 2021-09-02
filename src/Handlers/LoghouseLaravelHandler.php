<?php

namespace LoghouseIo\LoghouseLaravel\Handlers;

use LoghouseIo\LoghouseLaravel\Facades\LoghouseLaravel;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoghouseLaravelHandler
 * @package LoghouseIo\LoghouseLaravel\Handlers
 */
class LoghouseLaravelHandler extends AbstractProcessingHandler
{
    /**
     * @var string|null
     */
    private $bucketId;

    public function __construct(string $bucketId = null)
    {
        $this->bucketId = $bucketId;
    }

    /**
     * @param array $record
     */
    protected function write(array $record)
    {
        $metadata = [
            'log_level' => $record['level'],
            'log_level_name' => $record['level_name']
        ];

        if (!app()->runningInConsole()) {
            $metadata['user_id'] = Auth::check() ? Auth::user()->id : null;
            $metadata['ip'] = request()->ip();
        }

        if (!empty($record['context'])) {
            $metadata = array_merge($record['context'], $metadata);
        }

        LoghouseLaravel::log($record['message'], $metadata, $this->bucketId);
    }
}