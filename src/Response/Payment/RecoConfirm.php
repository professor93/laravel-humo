<?php
/**
 * Date: 9/29/2022
 * Time: 12:38 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Spatie\LaravelData\Data;

class RecoConfirm extends Data
{
    public function __construct(
        public string             $paymentID,
        public string             $paymentRef,
        public string             $action,
        public RecoConfirmDetails $details,
        public string             $status,
    )
    {
    }

    public function isOk(): bool
    {
        return (int)$this->action === 10;
    }
}
