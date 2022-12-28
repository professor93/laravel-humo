<?php

namespace Uzbek\LaravelHumo\Services\Middle\Requests;

use DateTime;
use Uzbek\LaravelHumo\Dtos\Middle\{Dto};

class TransactionHistoryRequest extends Dto
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
            'pan' => $this->pan,
            'dateFrom' => $this->from->format($this->dateFormat),
            'dateTo' => $this->to->format($this->dateFormat),
        ];
    }
}
