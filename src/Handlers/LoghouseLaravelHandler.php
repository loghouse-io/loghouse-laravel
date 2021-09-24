<?php

namespace LoghouseIo\LoghouseLaravel\Handlers;

use LoghouseIo\LoghouseLaravel\Facades\LoghouseLaravel;
use Monolog\Handler\AbstractProcessingHandler;

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

    /**
     * LoghouseLaravelHandler constructor.
     * @param string|null $bucketId
     */
    public function __construct(string $bucketId = null)
    {
        $this->bucketId = $bucketId;
    }

    /**
     * @param array $record
     */
    protected function write(array $record): void
    {
        $metadata = [
            'level' => strtolower($record['level_name'])
        ];

        $context = $record['context'];

        if (!empty($context)) {
            if (isset($context['exception'])) {

                $metadata['error'] = [
                    'caught' => false,
                    'message' => $record['message'],
                    'stacktrace' => $context['exception']->getTraceAsString()
                ];

                unset($context['exception']);

            } elseif (isset($context['error'])) {
                if ($context['error'] instanceof \Throwable) {

                    $metadata['error'] = [
                        'caught' => true,
                        'message' => $record['message'],
                        'stacktrace' => $context['exception']->getTraceAsString()
                    ];

                } elseif (is_string($context['error'])) {

                    $metadata['error'] = [
                        'caught' => null,
                        'message' => $context['error']
                    ];
                }

                unset($context['error']);
            }
        }

        $metadata = array_merge($context, $metadata);
        LoghouseLaravel::log($record['message'], $metadata, $this->bucketId);
    }
}
