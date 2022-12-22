<?php

namespace Uzbek\LaravelHumo\Dtos\Payment;

use Uzbek\LaravelHumo\Exceptions\ExceededAmountException;

class CreditDTO extends BaseDTO
{
    public string $owner_data = '';

    public function __construct(
        public string         $pan,
        public string         $expiry,
        public int            $amount,
        public string         $merchant_id,
        public string         $terminal_id,
        OwnerPassportDTO|null $ownerPassportDTO = null
    )
    {
        if (!empty($ownerPassportDTO)) {
            foreach ($ownerPassportDTO->toArray() as $key => $value) {
                $this->owner_data .= "<item><name>{$key}</name><value>{$value}</value></item>";
            }
        }
    }

    public function checkPassportlessLimit($max_amount)
    {
        if ($this->amount > $max_amount && empty($ownerPassportDTO)) throw new ExceededAmountException();
    }
}
