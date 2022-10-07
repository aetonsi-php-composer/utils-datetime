<?php

namespace Aetonsi\Utils;


class Datetime
{
    /**
     * Glavić date validator.
     *
     * Alternative: https://www.php.net/manual/en/function.date-parse.php
     *
     * @see https://stackoverflow.com/a/12323025
     * @see https://www.php.net/manual/en/function.checkdate.php#113205
     */
    public static function isValidDatetimeString($datetime, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $datetime);
        return $d && $d->format($format) === $datetime;
    }

    /**
     * Returns a closure (callable) that can be used as 'options' for filter_* functions with filter \FILTER_CALLBACK.
     * The closure will return the given $date formatted as $format if it's a valid datetime string, else will return the given $default value.
     */
    public static function getDatetimeValidator($default = null, $format = 'c')
    {
        return function ($date) use ($default, $format) {
            return self::isValidDatetimeString($date) ? self::datetimeFormatted($date, $format) : $default;
        };
    }

    /**
     * Returns a string representing the given $datetime formatted with the given $format, OR null on invalid $datetime string.
     */
    public static function datetimeFormatted($datetime = 'now', $format = 'c')
    {
        return self::isValidDatetimeString($datetime) ? (new \Datetime($datetime))->format($format) : null;
    }
}
