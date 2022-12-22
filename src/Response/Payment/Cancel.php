<?php
/**
 * Date: 8/24/2022
 * Time: 6:59 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Cancel extends Data
{
    public function __construct(
        public array|Optional $CancelRequestResponse,
    )
    {
    }

    public function isOk(): bool
    {
        return is_array($this->CancelRequestResponse);
    }
}
