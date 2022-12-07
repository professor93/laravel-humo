<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class PhoneDto extends Dto
{
    public function __construct(
        public readonly string  $msisdn,
        public readonly ?string $deliveryChannel = '-'
    )
    {
    }
}
