<?php
/**
 * Date: 8/23/2022
 * Time: 1:15 PM
 */

namespace Uzbek\LaravelHumo\Response\P2P;

use Spatie\LaravelData\Data;

class Create extends Data
{
    public function __construct(
        public string  $sessionID,
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
