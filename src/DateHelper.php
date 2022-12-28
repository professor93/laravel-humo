<?php
/**
 * Date: 9/30/2022
 * Time: 5:51 PM
 */

namespace Uzbek\LaravelHumo;

use Carbon\Carbon;
use DateTime;
use Throwable;

class DateHelper
{
    public static function expiry_date_from_string(string $format, string $date_string): DateTime|false
    {
        $carbon = self::date_from_string($format, $date_string);

        return $carbon ? $carbon->endOfMonth() : false;
    }

    public static function date_from_string(string $format, string $date_string): Carbon|DateTime|false
    {
        if (strlen($format) == 2 && strpos($format, 'd') === -1) {
            $format .= 'd';
            $date_string .= '01';
        }

        return Carbon::createFromFormat($format, $date_string);
    }

    public static function is_expired(DateTime $date): bool
    {
        try {
            return Carbon::now()->isAfter($date);
        } catch (Throwable) {
            return true;
        }
    }
}
