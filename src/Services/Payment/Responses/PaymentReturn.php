<?php
/**
 * Date: 9/29/2022
 * Time: 10:47 AM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PaymentReturn extends Data
{
    public function __construct(
        public array|Optional $ReturnPaymentResponse
    )
    {
    }

    public function isOk(): bool
    {
        return is_array($this->ReturnPaymentResponse);
    }
}
