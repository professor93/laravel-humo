<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class EmailDto extends Dto
{
    public function __construct(public readonly string $To)
    {
    }
}
