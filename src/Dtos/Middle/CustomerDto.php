<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class CustomerDto extends Dto
{
    public function __construct(
        public readonly string $customerId,
        public readonly string $bankId,
    )
    {
    }
}
