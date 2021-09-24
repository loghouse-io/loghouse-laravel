<?php

namespace LoghouseIo\LoghouseLaravel\Utils;

use DateTime;

/**
 * Class LoghouseLaravelUtils
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravelUtils
{
    /**
     * @return string
     */
    public static function generateRequestId(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(5));
    }

    /**
     * @return string
     */
    public static function getDataNowISO8061(): string
    {
        $dateTime = new DateTime();
        return sprintf('%s.%sZ',
            explode('+', $dateTime->format('c'))[0],
            $dateTime->format('v')
        );
    }

    /**
     * @param array $headers
     * @return array
     */
    public static function headersFormatted(array $headers): array
    {
        $headersFormatted = [];
        foreach ($headers as $name => $values) {
            $headersFormatted[] = sprintf('%s: %s', $name, $values[0]);
        }

        return $headersFormatted;
    }
}
