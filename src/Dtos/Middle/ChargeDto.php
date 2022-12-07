<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class ChargeDto extends Dto
{
    public function __construct(
        public readonly string  $chargeAgreement,
        public readonly string  $chargeAccount,
        public readonly ?string $chargeDate = null,
    )
    {
    }
}
