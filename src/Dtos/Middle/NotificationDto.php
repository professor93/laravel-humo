<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

class NotificationDto extends Dto
{
    public function __construct(
        public readonly ?string $timeZone = null,
        public readonly ?string $timeInterval = null,
        public readonly ?string $sender = null,
    )
    {
    }
}
