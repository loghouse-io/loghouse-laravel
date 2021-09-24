<?php

namespace LoghouseIo\LoghouseLaravel\Factories;

use Dotenv\Parser\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntryImpl;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntry;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelRequestEntryImpl;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelRequestEntry;
use LoghouseIo\LoghouseLaravel\Utils\LoghouseLaravelUtils;

/**
 * Class LoghouseLaravelEntryFactory
 * @package LoghouseIo\LoghouseLaravel\Favrories
 */
class LoghouseLaravelEntryFactory
{
    /**
     * @param string $bucketId
     * @param string $message
     * @param array $metadata
     * @return Entry
     */
    public static function create(
        string $bucketId,
        string $message,
        array $metadata = []
    ): LoghouseLaravelEntry {
        $timestamp = LoghouseLaravelUtils::getDataNowISO8061();
        return new LoghouseLaravelEntryImpl($bucketId, $message, $timestamp, $metadata);
    }

    public static function createRequest(Request $request, string $userId = null): LoghouseLaravelRequestEntry
    {
        $requestId = LoghouseLaravelUtils::generateRequestId();

        return new LoghouseLaravelRequestEntryImpl(
            $requestId,
            LoghouseLaravelUtils::getDataNowISO8061(),
            [
                'user_id' => $userId,
                'level' => 'info',
                'ip' => $request->ip(),
                'request_id' => $requestId,
                'request' => [
                    'path' => $request->getPathInfo(),
                    'method' => $request->method(),
                    'headers' => LoghouseLaravelUtils::headersFormatted($request->header()),
                    'laravel' => [
                        'route_name' => $request->route()->getName()
                    ]
                ],
                'response' => [
                    'code' => 0
                ]
            ]
        );
    }
}
