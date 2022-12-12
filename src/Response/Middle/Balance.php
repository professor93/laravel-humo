<?php

namespace Uzbek\LaravelHumo\Response\Middle;

use Spatie\LaravelData\Data;

class Balance extends Data
{
    public float $initialAmountSum;
    public float $bonusAmountSum;
    public float $creditLimitSum;
    public float $lockedBackofficeAmountSum;
    public float $lockedBackofficeAmountOfflineSum;
    public float $lockedAmountSum;
    public float $availableAmountSum;

    public function __construct(
        public string $currency,
        public float  $initialAmount,
        public float  $bonusAmount,
        public float  $creditLimit,
        public float  $lockedBackofficeAmount,
        public float  $lockedBackofficeAmountOffline,
        public float  $lockedAmount,
        public float  $availableAmount,
    )
    {
        $this->initialAmountSum = $this->amount_in_sum($this->initialAmount);
        $this->bonusAmountSum = $this->amount_in_sum($this->bonusAmount);
        $this->creditLimitSum = $this->amount_in_sum($this->creditLimit);
        $this->lockedBackofficeAmountSum = $this->amount_in_sum($this->lockedBackofficeAmount);
        $this->lockedBackofficeAmountOfflineSum = $this->amount_in_sum($this->lockedBackofficeAmountOffline);
        $this->lockedAmountSum = $this->amount_in_sum($this->lockedAmount);
        $this->availableAmountSum = $this->amount_in_sum($this->availableAmount);
    }

    private function amount_in_sum($amount): string
    {
        if ($amount !== 0)
            return round($amount / 100, 2);
        return $amount;
    }
}

