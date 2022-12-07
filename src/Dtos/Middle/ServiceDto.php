<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class ServiceDto extends Dto
{
    public function __construct(
        public readonly string  $serviceID = 'MB-ALL',
        public readonly ?string $serviceChannel = '-',
    )
    {
    }
}
