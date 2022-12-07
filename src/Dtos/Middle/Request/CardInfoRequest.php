<?php

namespace Uzbek\LaravelHumo\Dtos\Middle\Request;

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
