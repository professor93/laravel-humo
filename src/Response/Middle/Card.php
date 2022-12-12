<?php

namespace Uzbek\LaravelHumo\Response\Middle;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Card extends Data
{
    public function __construct(
        public string          $institutionId,
        public string          $primaryAccountNumber,
        public string          $expiry,
        public int             $cardSequenceNumber,
        public string          $cardholderId,
        public string          $nameOnCard,
        public string          $cardUserId,
        public string          $bankC,
        public int             $pinTryCount,
        public array           $statuses,

        public string|Optional $effectiveDate,
        public string|Optional $updateDate,
        public string|Optional $prefixNumber,
        public string|Optional $accountRestrictionsFlag,
        public string|Optional $commissionGroup,
        public string|Optional $riskGroup,

        public string|Optional $cardholderPassword,
        public string|Optional $additionalInfo,
        public string|Optional $riskGroup2,
    )
    {
    }

    public function isActive(): bool
    {
        return array_filter($this->statuses['item'], static fn($item) => $item['type'] === 'card')[0]['actionCode'] === '000';
    }
}

