<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;


class CardDto extends Dto
{
    /**
     * @param ServiceDto[] $Service
     */
    public function __construct(
        public readonly string     $pan,
        public readonly array      $Service = [new ServiceDto],
        public readonly ?string    $label = null,
        public readonly ?string    $ownerID = null,
        public readonly ?ChargeDto $Charge = null,
    )
    {
    }
}
