<?php
/**
 * Date: 9/29/2022
 * Time: 12:28 PM
 */

namespace Uzbek\LaravelHumo\Exceptions;

class ExceededAmountException extends Exception
{
    protected $code = 20009;

    protected $message = 'Max amount for unidentified users 11.999.999';
}
