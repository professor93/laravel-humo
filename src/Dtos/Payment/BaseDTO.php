<?php
/**
 * Date: 8/19/2022
 * Time: 11:20 AM
 */

namespace Uzbek\LaravelHumo\Dtos\Payment;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Spatie\LaravelData\Data;

abstract class BaseDTO extends Data
{
    protected string|null $_paymentRef = null;

    public function getPaymentRef(): string
    {
        if ($this->_paymentRef === null) {
            $this->_paymentRef = rescue(static fn() => Uuid::uuid4()->toString(), Str::random() . '-' . time());
        }
        return $this->_paymentRef;
    }
}
