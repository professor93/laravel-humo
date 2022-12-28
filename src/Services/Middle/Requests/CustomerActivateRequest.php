<?php

namespace Uzbek\LaravelHumo\Services\Middle\Requests;

use Uzbek\LaravelHumo\Dtos\Middle\{CardDto, ChargeDto, Dto, EmailDto, PhoneDto};

class CustomerActivateRequest extends Dto
{
    public function __construct(
        public readonly CardDto    $Card,
        public readonly PhoneDto   $Phone,
        public readonly string     $bankId = 'MB_STD',
        public readonly string     $language = 'ru_translit',
        public readonly ?string    $Notification = null,
        public readonly ?ChargeDto $Charge = null,
        public readonly ?EmailDto  $Email = null,
        public readonly ?string    $accessCode = null,
    )
    {
    }
}
