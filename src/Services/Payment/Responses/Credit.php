<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Spatie\LaravelData\Data;

class Credit extends Data
{
    public function __construct(
        public string        $paymentID,
        public string        $paymentRef,
        public CreditDetails $details,
        public string        $action,
    )
    {
    }


    public function isOk(): bool
    {
        return (int)$this->action === 4;
    }
}
