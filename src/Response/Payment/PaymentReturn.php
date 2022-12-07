<?php
/**
 * Date: 9/29/2022
 * Time: 10:47 AM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

class PaymentReturn
{
    public bool $isOk;

    public function __construct(array $attributes)
    {
        $this->isOk = isset($attributes['ReturnPaymentResponse']);
    }
}
