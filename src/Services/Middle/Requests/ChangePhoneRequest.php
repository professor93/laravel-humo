<?php

namespace Uzbek\LaravelHumo\Services\Middle\Requests;

use Uzbek\LaravelHumo\Dtos\Middle\{Dto, PhoneDto};

class ChangePhoneRequest extends Dto
{
    public function __construct(
        public readonly string $customerId,
        public readonly PhoneDto  $Phone,
    )
    {
    }
}
