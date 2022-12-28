<?php
/**
 * Date: 8/24/2022
 * Time: 6:39 PM
 */

namespace Uzbek\LaravelHumo\Services\P2P\Responses;

use Spatie\LaravelData\Data;

class Confirm extends Data
{
    public function __construct(
        public string  $paymentID,
        public string  $paymentRef,
        public Details $details,
        public string  $action,
    )
    {
    }

    public function isOk(): bool
    {
        return (int)$this->action === 10;
    }
}
