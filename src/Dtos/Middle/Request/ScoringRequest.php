<?php

namespace Uzbek\LaravelHumo\Dtos\Middle\Request;

use DateTime;
use Uzbek\LaravelHumo\Dtos\Middle\{Dto};

class ScoringRequest extends Dto
{
    private string $dateFormat = 'Y-m-d\TH:i:s';

    public function __construct(
        public readonly string   $pan,
        public readonly DateTime $from,
        public readonly DateTime $to,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'card' => $this->pan,
            'date_from' => $this->from->format($this->dateFormat),
            'date_to' => $this->to->format($this->dateFormat),
        ];
    }
}
