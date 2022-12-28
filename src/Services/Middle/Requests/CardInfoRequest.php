<?php

namespace Uzbek\LaravelHumo\Services\Middle\Requests;

use Uzbek\LaravelHumo\Dtos\Middle\{Dto};

class CardInfoRequest extends Dto
{
    public function __construct(
        public readonly string $primaryAccountNumber,
        public readonly bool   $mb_flag = true,
    )
    {
    }
}
