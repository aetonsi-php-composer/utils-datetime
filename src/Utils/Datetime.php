<?php

namespace Aetonsi\Utils;


class Datetime
{
    /**
     * Returns true if $datetime is a valid datetime string. If $format is specified, the string must be in the given format, to pass the check.
     * @see https://stackoverflow.com/questions/11029769/function-to-check-if-a-string-is-a-date
     *
     * @param string $datetime
     * @param null|string $format
     * @return bool
     */
    public static function isValidDatetimeString($datetime, $format = null)
    {
        if ($format) {
            // https: //www.php.net/manual/en/function.checkdate.php#113205
            $d = \DateTime::createFromFormat($format, $datetime);
            $result = $d && $d->format($format) === $datetime;
        } else {
            $parsed = \date_parse($datetime);
            $result = ($parsed['error_count'] === 0) && ($parsed['warning_count'] === 0);
            // alternative: $result = \is_numeric(\strtotime($datetime))
            // alternative: try{new \Datetime($datetime);$result=true}catch(){$result=false}
        }
        return $result;
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
