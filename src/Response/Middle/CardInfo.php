<?php

namespace Uzbek\LaravelHumo\Response\Middle;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class CardInfo extends Data
{
    public function __construct(
        public int                     $listSize,
        public Card                    $card,
        #[DataCollectionOf(Account::class)]
        public DataCollection|Optional $account,
        public Balance                 $balance,
        public Mb                      $mb,
    )
    {
    }

    public function isActive(): bool
    {
        return $this->card->isActive() && $this->mb->state === 'on';
    }

    public function availableBalance(): float
    {
        return $this->balance->availableAmountSum;
    }

    public function phone(): string
    {
        return str_replace(['+', ' ', '-'], '', $this->mb->phone);
    }
}

