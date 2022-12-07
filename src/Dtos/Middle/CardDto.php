<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;


class CardDto extends Dto
{
    /**
     * @param string $pan
     * @param ServiceDto[] $Service
     * @param string|null $label
     * @param string|null $ownerID
     * @param ChargeDto|null $Charge
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
