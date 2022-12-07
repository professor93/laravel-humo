<?php

namespace Uzbek\LaravelHumo\Dtos\Payment;

class PaymentHoldDTO extends BaseDTO
{
    public function __construct(
        public string $pan,
        public string $expiry,
        public int    $amount,
        public string $merchant_id,
        public string $terminal_id
    )
    {
    }
}
